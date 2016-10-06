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
     * $agencia: onde será salvo o numero da agencia, como vetor
     * $numeroConta: onde será salvo o numero da conta, como vetor
     *
     * @var array
     */
    private $agencia;
    private $numeroConta;

    /**
     * Bank constructor.
     * @param string $agencia
     * @param string $numeroConta
     * @throws \Exception
     */
    public function __construct(string $agencia, string $numeroConta) {

        $this->numeroConta=$numeroConta;
        $this->agencia=$agencia;
        $this->numeroConta=str_replace('P', '0', $this->numeroConta);
        $this->numeroConta= (string)str_replace('-', '', $this->numeroConta);
        $this->agencia=str_replace('P', '0', $this->agencia);
        $this->agencia= (string)str_replace('-', '', $this->agencia);
        $value = (float) ($this->agencia . $this->numeroConta);

        parent::__construct($value);
        
        $this->agencia = str_split($this->agencia);
        $this->numeroConta=str_split($this->numeroConta);

    }

    /**
     *
     * Converte a conta para string, adicionando o ' - '.
     * @return string
     */
    public function getAccountFormatted():string {
        
        $format = ' ';
        $x = count($this->numeroConta);
        
        foreach ($this->numeroConta as $y) {

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
        $x = count($this->agencia);
        $format = '';
        foreach ($this->agencia as $y) {

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
        if (count($this->numeroConta) > 8 or count($this->agencia) > 5){
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

            $posic = count($this->agencia);

            $inicio = 5 - $posic;

            while ($inicio < 4) {

                $soma = $soma + ((int)$this->agencia[$cont] * $valores[$inicio]);
                $inicio++;
                $cont++;
            }
            $mod = 11 - ($soma % 11);
            if ($mod == 10 or $mod == 11) {
                if ($this->agencia[$cont] == 0) {
                    return true;
                }
            } else {
                if ($mod == $this->agencia[$cont]) {
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


            $posic = 8 - count($this->numeroConta);

            $pesos = array(2, 7, 6, 5, 4, 3, 2);
            while ($posic < 7) {
                $soma = $soma + ($pesos[$posic] * $this->numeroConta[$contador]);
                $contador++;
                $posic++;
            }
            $mod = $soma % 11;
            if ($mod == 0 || $mod == 1) {
                if ($this->numeroConta[$contador] == 0) {
                    return true;
                }
            } else {
                $mod = 11 - $mod;
                if ($mod == $this->numeroConta[$contador]) {
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
