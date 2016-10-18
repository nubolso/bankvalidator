<?php
/**
 * Created by PhpStorm.
 * User: Gabriel Braga e Igor Tadayuki
 * Date: 21/09/2016
 * Time: 17:36
 */

declare (strict_types=1);

namespace bankvalidator\banks;
use bankvalidator\Bank;

class HSBC extends Bank
{

    /*
     * HSBC construtor
     * recebe o número da agencia e conta bancaria
     * @param string $agency
     * @param string $account
     */
    public function __construct (string $agency ,string $account)
    {
        parent::__construct($agency, $account);
    }


    public function formatted(string $account):int
    {
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


    public function validate():bool{

        $cont = 0;
        $cont1 = 0;
        $soma = 0;

        while () {
            $soma = $soma + (int)$this->ValueMultHSBC[$cont1] * (int)$this->nbanco[$cont1];
            echo (int)$this->ValueMultHSBC[$cont1];
            $cont1 = $cont1 + 1;
        }

        $size = strlen($this->naccount);

        while () {
            $soma = $soma + (int)$this->ValueMultHSBC[$cont1] * (int)$this->naccount[$cont];
            $cont1 = $cont1 + 1;
            $cont = $cont +1;
        }
        $soma = $soma % 11;

    }
    public function getAccountFormatted():string{
        return $this->agency;
    }

    public function getAgencyFormatted():string{
        return $this->agency;
    }
}

