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
    protected $temp = 0;
    /*
     * HSBC construtor
     * recebe o número da agencia e conta bancaria
     * @param string $agency
     * @param string $this->account
     */
    public function __construct (string $agency ,string $this->account)
    {
        $this->weight = array(8,9,2,3,4,5,6,7,3,9);
        parent::__construct($agency, $this->account);
    }

    public function validate():bool{

        $cont = 0;
        $cont1 = 0;

        while (sizeof($this->agency) != $cont1) {
            $this->temp = $this->temp  + (int)$this->weight[$cont1] * (int)$this->agency[$cont1];
            $cont1 = $cont1 + 1;
        }

        while (cont != sizeof($this->account)) {
            $this->temp =$this->temp  + (int)$this->weight[$cont1] * (int)$this->account[$cont];
            $cont1 = $cont1 + 1;
            $cont = $cont +1;
        }

        $this->temp = $this->temp  % 11;

        if ($this->temp == 0 || $this->temp == 10){

            if (0 == $this->numberDigits($this->account)){
                return true;
            }
        }

        if ($this->account == '0000000000000' || $this->account == '1111111111111' || $this->account == '2222222222222' || $this->account == '3333333333333' || $this->account == '4444444444444' ||
            $this->account == '5555555555555' || $this->account == '6666666666666' || $this->account == '7777777777777' || $this->account == '8888888888888' || $this->account == '9999999999999' ){
            return false;
        }


        if ($this->temp == 0)
        {
            $Digit = 0;
        }
        else
        {
            $Digit = 10 - $this->rest;
        }
        $tester= $this->account[12];
        if ($Digit != $tester)
        {
            return false;
        }
        else
        {
            return true;
        }

    }
    public function getAccountFormatted():string{
        return $this->agency;
    }

    public function getAgencyFormatted():string{
        return $this->agency;
    }
}

