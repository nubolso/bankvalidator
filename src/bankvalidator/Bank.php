<?php
namespace bankvalidator;
abstract class Bank{
    public $agency;
	public $account;
    protected $weight;
    function __construct(string $agency, string $account)
    {
        $this->agency = $agency;
        $this->account = $account;
    }
    public function getAgencyToInt():int{

        return $this->toInt($this->agency);
    }
	protected function toInt(string $value):int{
		$converted = str_replace('.','',$value);
        $converted = str_replace('-','',$converted);
        $converted = str_replace('/','',$converted);
        $converted = str_replace(' ', '', $converted);
        return (int)$converted;
	}
	public function getAccountToInt():int{

        return $this->toInt($this->account);
    }
	/**
    * conta o número de digitos
    * @param int $number
    * @return int quantidade de digitos de um número
    */
    protected function numberDigits(int $number):int
    {
        $parameters = 10;
        $frags = 0;
        while ($number >= 1) {
            $tmp = $number % $parameters;
            $number = ($number - $tmp) / 10;
            $frags = $frags + 1;
        }
        return $frags;
    }

    /**
     * valida o número da conta ou agencia no mod 11 check digit
     * @param string $accountAgency
     * @return bool
     */
    protected function validateMultiply(string $accountAgency):bool
    {
        $number = $this->formatted($accountAgency);
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
     * formata a string com apenas números
     * @param string $account or $agency.
     * @return int com apenas números e substituindo 'x' por '0', ignora outros caracteres.
     */
    protected function formatted(string $account):int
    {
        $account = strtolower($account);
        $tmp2 = array();
        $tmp1 = str_split($account);
        $i = 0;
        foreach($tmp1 as $char){
            //função ord retorna o número ASCII do caractere
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
     * formata os números da conta e agencia e retorna neste padrão xxxx-x
     * @param string $number
     * @return string
     */
    protected function getFormatted(string $number):string
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
        return $account2;
    }
    abstract public function validate():bool;
    abstract public function getAccountFormatted():string;
    abstract public function getAgencyFormatted():string;
}
