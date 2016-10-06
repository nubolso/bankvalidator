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
     * $: onde será salvo o numero da agency, como vetor
     * $accountNumber: onde será salvo o numero da conta, como vetor
     *
     * @var array
     */
    private $agency;
    private $accountNumber;

    /**
     * Bank constructor.
     * @param string $agency
     * @param string $accountNumber
     * @throws \Exception
     */
    public function __construct(string $agency, string $accountNumber) {

        parent::__construct($agency, $accountNumber);

        $this->accountNumber=$this->toInt($accountNumber);
        $this->agency=$this->toInt($agency);

        $this->agency = str_split($this->agency);
        $this->accountNumber=str_split($this->accountNumber);

    }

    /**
     *
     * Converte a conta para string, adicionando o ' - '.
     * @return string
     */
    public function getAccountFormatted():string {
        
        $format = ' ';
        $x = count($this->accountNumber);
        
        foreach ($this->accountNumber as $y) {

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
        $x = count($this->agency);
        $format = '';
        foreach ($this->agency as $y) {

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
    private function verificaTamanho():bool{
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
    public function validateAg():bool {

        if ($this->verificaTamanho()) {

            $valores = array(5, 4, 3, 2);
            $soma = 0;
            $cont = 0;

            $posic = count($this->agency);

            $inicio = 5 - $posic;

            while ($inicio < 4) {

                $soma = $soma + ((int)$this->agency[$cont] * $valores[$inicio]);
                $inicio++;
                $cont++;
            }
            $mod = 11 - ($soma % 11);
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
    public function validateC():bool
    {

        if ($this->verificaTamanho()) {
            $soma = 0;
            $contador = 0;


            $posic = 8 - count($this->accountNumber);

            $pesos = array(2, 7, 6, 5, 4, 3, 2);
            while ($posic < 7) {
                $soma = $soma + ($pesos[$posic] * $this->accountNumber[$contador]);
                $contador++;
                $posic++;
            }
            $mod = $soma % 11;
            if ($mod == 0 || $mod == 1) {
                if ($this->accountNumber[$contador] == 0) {
                    return true;
                }
            } else {
                $mod = 11 - $mod;
                if ($mod == $this->accountNumber[$contador]) {
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
        if ($this->validateAg() == 1 and $this->validateC() == 1) {
            return true;
        }
        return false;
    }
}

}
