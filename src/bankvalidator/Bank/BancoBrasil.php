<?php

namespace bankvalidator\Bank;
use bankvalidator\Bank;

class BancoBrasil extends Bank
{
    /**
     * Bancobrasil construtor
     * recebe o número da agencia e conta bancaria
     * bancobrasil constructor.
     * @param string $agency
     * @param string $account
     */
    public function __construct(string $agency, string $account)
    {
        parent::__construct($agency, $account);
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
     * completa com zero(s) a esquerda caso o tenha.
     * @param string $accountOrAgency
     * @return array|string
     */
    protected function zeroLeft(string $accountOrAgency):string
    {
        $accountZero = $accountOrAgency;
        $accountZero = str_split($accountZero);
        $i = 0;
        $cont = 0;
        while($i < count($accountZero)){
            if($accountZero[$i] == '0'){
                $cont++;
            }
            else{
                $i = count($accountZero);
            }
            $i++;
        }
        $accountFormatted = (string)$this->getFormatted($accountOrAgency);
        $accountFormatted = str_split($accountFormatted);
        $i = 0;
        $j = 0;
        $aux = array();
        if($cont > 0) {
            while ($j < count($accountFormatted)) {
                if ($i < $cont) {
                    $aux[$i] = '0';
                    $i++;
                }
                else{
                    $aux[$i] = $accountFormatted[$j];
                    $j++;
                    $i++;
                }
            }
            $aux = implode($aux);
            $accountFormatted = $aux;
        }
        else{
            $accountFormatted = implode($accountFormatted);
        }
        return $accountFormatted;
    }
    /**
     * formata o número da conta no padrão xxxx-x
     * @return string
     */
    public function getAccountFormatted():string
    {
        return $this->zeroLeft($this->account);
    }

    /**
     * formata o número da agencia no padrão xxxx-x
     * @return string
     */
    public function getAgencyFormatted():string
    {
        return $this->zeroLeft($this->agency);
    }

    /**
     * valida agencia
     * @return bool
     */
    protected function validateAgency():bool{
        if(!$this->limitedNumbersAgency()){
            return false;
        }
        if($this->validateMultiply($this->agency)){
            return true;
        }
        return false;
    }

    /**
     * valida conta
     * @return bool
     */
    protected function validateAccount():bool{
        if(!$this->limitedNumbersAccount()){
            return false;
        }
        if($this->validateMultiply($this->account) ){
            return true;
        }
        return false;
    }

    /**
     * valida conta e agencia
     * @return bool
     */
    public function validate():bool
    {
        if($this->validateAccount() AND $this->validateAgency())
        {
            return true;
        }
        return false;
    }
    /**
     * retorna true caso a quantidade de digitos maxima seja menor igual a 5
     * @return bool
     */
    private function limitedNumbersAgency():bool
    {
        $number = $this->numberDigits($this->formatted($this->agency));
        if ($number > 5) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * retorna true caso a quantidade de digitos maxima seja menor igual a 12
     * @return bool
     */
    private function limitedNumbersAccount():bool
    {
        $number = $this->numberDigits($this->formatted($this->account));
        if ($number > 12) {
            return false;
        } else {
            return true;
        }
    }
}