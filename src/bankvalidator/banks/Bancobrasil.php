<?php
namespace src\bankvalidator\banks;
use src\bankvalidator\Bank;
class Bancobrasil extends Bank
{
    /**
     * Bancobrasil construtor
     * recebe o número da agencia e conta bancaria
     * bancobrasil constructor.
     * @param string $agency
     * @param string $account
     */
    public function __construct(string $agency, string $account){
        parent::__construct($agency, $account);
    }
    /**
     * formata a string com apenas números
     * @param string $account or $agency.
     * @return int com apenas números e substituindo 'x' por '0', ignora outros caracteres.
     */
    protected function formatted(string $account):int{
        $account = strtolower($account);
        $tmp2 = array();
        $tmp1 = str_split($account);
        $i = 0;
        foreach($tmp1 as $char){
            if((ord($char) >= 48 AND ord($char) <= 57)){
                $tmp2[$i] = $char;
                $i++;
            }
            if(ord($char) == 120){
                $tmp2[$i] = '0';
                $i++;
            }
        }
        $account = implode("", $tmp2);
        return (int)$account;
    }

    /**
     * formata os números da conta e agencia neste padrão xxxx-x
     * @param string $number
     * @return string
     */
    private function getFormatted(string $number):string
    {
        $account1 = (string)$this->formatted($number);
        $account1 = str_split($account1);
        $account2 = array();
        $size = count($account1);
        $i = 0;
        $j = 0;
        while($i < $size){
            if($j == $size - 1){
                $account2[$j] = '-';
                $j++;
            }
            else{
                $account2[$j] = $account1[$i];
                $i++;
                $j++;
            }
        }
        if($account2[$size - 1] == '0'){
            $account2[$size - 1] = 'x';
        }
        $account2 = implode($account2);
        return (string)$account2;
    }
    public function getAccountFormatted():string
    {
        return $this->getFormatted($this->account);
    }
    public function getAgencyFormatted():string
    {
        return $this->getFormatted($this->agency);
    }
    /**
     * valida o número com digito verificador
     * @param string $account or $agency.
     * @return bool 1 = $account or $agency corretos, 0 = $account or $agency incorretos.
     */
    public function validateMultiply(string $account):bool
    {
        $number = $this->formatted($account);
        $parameters = pow(10, ($this->numberDigits($number) - 1));
        $md11 = $this->numberDigits($number);
        $size = $this->numberDigits($number);
        $sum = 0;
        for ($i = 0; $i < $size; $i++) {
            if ($i == ($size - 1)) {
                $resto = $sum % 11;
                $resto = 11 - $resto;
                if ($resto == 10 || $resto == 11) {
                    $resto = 0;
                }
                if ($number == $resto) {
                    return true;
                } else {
                    return false;
                }
            }
            $tmp = $number % $parameters;
            $dig = ($number - $tmp) / $parameters;
            $sum = $sum + ($dig * $md11);
            $md11 = $md11 - 1;
            $number = $tmp;
            $parameters = $parameters / 10;
        }
        return false;
    }
    /**
     * testa tanto o número da agencia como o numero da conta
     * @verifica se os números da agencia e conta estão corretos, com o digito verificador
     * @return bool false = conta e agencia incorretas, true = agencia e conta corretas
     */
    public function validate():bool{
        if($this->validateMultiply($this->account) AND $this->validateMultiply($this->agency) ){
            return true;
        }
        return false;
    }
}