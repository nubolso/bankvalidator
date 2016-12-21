<?php
namespace bankvalidator\banks;
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
     * valida o número com digito verificador
     * @param string $account or $agency.
     * @return bool 1 = $account or $agency corretos, 0 = $account or $agency incorretos.
     */

    public function validateAgency():bool{
        if($this->validateMultiply($this->agency)){
            return true;
        }
        return false;
    }
    public function validateAccount():bool{
        if($this->validateMultiply($this->account) ){
            return true;
        }
        return false;
    }
}