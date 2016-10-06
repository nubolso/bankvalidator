<?php


declare(strict_types=1);


namespace banks\Bradesco;

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
     *
     * $agency: onde será salvo o numero da agência, como vetor
     * $accountNumber: onde será salvo o numero da conta, como vetor
     *
     * @var array
        private $agency;
        priv0ate $accountNumber;
    */

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

        $accountNumber=str_split($this->toInt($this->account));


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
    public function getAgencyFormatted():string{

        $agencyformat =str_split($this->toInt($this->agency));

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
     *
     * Metodo que verifica se a quantidade de numeros digitadas foi superior ao numero máximo de dígitos
     *
     * @return bool
     */
    private function checkSize():bool{
        if (count($this->accountNumber) > 8 or count($this->agency) > 5){
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

        if ($this->checkSize()) {

            $values = array(5, 4, 3, 2);
            $sum = 0;
            $cont = 0;

            $positions = count($this->agency);

            $start = 5 - $positions;

            while ($start < 4) {

                $sum = $sum + ((int)$this->agency[$cont] * $values[$start]);
                $start++;
                $cont++;
            }
            $mod = 11 - ($sum % 11);
            if ($mod == 10 or $mod == 11) {
                if ($this->agency[$cont] == 0) {
                    return true;
                }
            } else {
                if ($mod == $this->agency[$cont]) {
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

        if ($this->checkSize()) {
            $sum = 0;
            $counter = 0;


            $position = 8 - count($this->accountNumber);

            $pesos = array(2, 7, 6, 5, 4, 3, 2);
            while ($position < 7) {
                $sum = $sum + ($pesos[$position] * $this->accountNumber[$counter]);
                $counter++;
                $position++;
            }
            $mod = $sum % 11;
            if ($mod == 0 || $mod == 1) {
                if ($this->accountNumber[$counter] == 0) {
                    return true;
                }
            } else {
                $mod = 11 - $mod;
                if ($mod == $this->accountNumber[$counter]) {
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
}
