<?php


declare(strict_types=1);


namespace bankvalidator\banks;

use bankvalidator\Bank;


/**
 *
 * Classe validadora de contas Bradesco
 *
 * Class Bradesco
 * @package Validator\Bank
 *
 */
Class Bradesco extends Bank {



    /**
     * Bradesco constructor.
     * @param string $agency
     * @param string $accountNumber
     */
    public function __construct(string $agency, string $accountNumber) {

        $agency = str_replace('P','0',$agency);

        parent::__construct($agency, $accountNumber);

    }

    /**
     *
     * Converte a conta para string, adicionando o ' - '.
     * @return string
     */
    public function getAccountFormatted():string {

        $accountNumber = str_split((string)($this->toInt($this->account)));


        $format = ' ';
        $x = count($accountNumber);
        
        foreach ($accountNumber as $y) {

            if ($x == 1) {
                $format = $format . '-';
            }
            $format = $format . $y;
            $x--;
        }
        

        return $format;
    }


    /**
     *
     * Converte a agência para string, adicionando o ' - '.
     * @return string
     */
    public function getAgencyFormatted():string {

        $agencyformat = str_split((string)($this->toInt($this->agency)));

        $x = count($agencyformat);
        $format = '';
        foreach ($agencyformat as $y) {

            if ($x == 1) {
                $format = $format . '-';
            }
            $format = $format . $y;
            $x--;
        }
        return $format;
    }
    
    /**
    * Converte a agência e a conta para string.
    * @return string
    */
    public function getFormatted():string  {
        return ($this->getAgencyFormatted().$this->getAccountFormatted());
    }

    /**
     *
     * Metodo que verifica se a quantidade de numeros digitadas foi superior ao numero máximo de dígitos
     * @param string $tocheck
     * @param integer $type
     * @return bool
     */
    private function checkSize(string $tocheck, int $type):bool{
        if (((count($tocheck) > 8) and (type == 1)) or (count($tocheck) > 5) and (type == 0))) {
            return false;
        }
        return true;
    }


    /**
     *
     * Verifica se a agência é valida, de acordo com o dígito verificador
     *
     * @return bool
     */
    public function validateAgency():bool {

        $agencyformat = str_split((string)($this->toInt($this->agency)));
        
        if ($this->checkSize($agencyformat, 0)) {

            $values = array(5, 4, 3, 2);
            $sum = 0;
            $cont = 0;

            $positions = count($agencyformat);

            $start = 5 - $positions;

            while ($start < 4) {

                $sum = $sum + ((int)$agencyformat[$cont] * $values[$start]);
                $start++;
                $cont++;
            }
            $mod = 11 - ($sum % 11);
            if ($mod == 10 or $mod == 11) {
                if ($agencyformat[$cont] == 0) {
                    return true;
                }
            } else {
                if ($mod == $agencyformat[$cont]) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     *
     * Verifica se a conta é válida de acordo com o dígito verificador
     *
     * @return bool
     */
    public function validateAccount():bool
    {
        
        $accountformat = str_split((string)($this->toInt($this->account)));

        if ($this->checkSize($accountformat, 1)) {
            $sum = 0;
            $counter = 0;

            $this->account = str_split($this->account);

            $position = 8 - count($accountformat);

            $pesos = array(2, 7, 6, 5, 4, 3, 2);
            while ($position < 7) {
                $sum = $sum + ($pesos[$position] * $accountformat[$counter]);
                $counter++;
                $position++;
            }
            $mod = $sum % 11;
            if ($mod == 0 || $mod == 1) {
                if ($accountformat[$counter] == 0) {
                    return true;
                }
            } else {
                $mod = 11 - $mod;
                if ($mod == $accountformat[$counter]) {
                    return true;
                }
            }
        }
            return false;
    }


    /**
     *
     * Verifica se o conjunto conta-agência é valido, de acordo com os digitos verificadores
     *
     * @return bool
     */
    public function validate():bool {
        if ($this->validateAgency() == 1 and $this->validateAccount() == 1) {
            return true;
        }
        return false;
    }
}
