<?php
/**
 * Created by PhpStorm.
 * User: Genivaldo
 * Date: 21/09/2016
 * Time: 08:51
 */
namespace bankvalidator\banks\Bancobrasil;
use bankvalidator\Bank;
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
     * @return string com apenas números e substituindo 'x' por '0', ignora outros caracteres.
     */
    protected function formated(string $account):int{
        $account = strtolower($account);
        $tmp2 = array();
        $tmp1 = str_split($account);
        $i = 0;
        foreach($tmp1 as $char){
            if((ord($char) >= 48 AND ord($char) <= 57) OR ord($char) == 120){
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
     * valida o número com digito verificador
     * @param string $account or $agency.
     * @return bool 1 = $account or $agency corretos, 0 = $account or $agency incorretos.
     */
    protected function validateBrasil(string $account):bool
    {
        $number = $this->formated($account);
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
     * @return int -1 = agencia incorreta, 0 = conta incorreta, 1 = agencia e conta estão corretas
     */


    public function validateAgencyAccount():int{
        if(!$this->validateBrasil($this->account)){
            return 0;
        }
        if(!$this->validateBrasil($this->agency)){
            return -1;
        }
        return 1;
    }
}