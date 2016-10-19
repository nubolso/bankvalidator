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

    public function __construct (string $agency ,string $account)
    {
        $this->weight = array(8,9,2,3,4,5,6,7,8,9);
        parent::__construct($agency, $account);
    }

    /**
     * @return bool
     */
    public function validate():bool
    {
        if ($this->account == '0000000000000' || $this->account == '1111111111111' || $this->account == '2222222222222' || $this->account == '3333333333333' || $this->account == '4444444444444' ||
            $this->account == '5555555555555' || $this->account == '6666666666666' || $this->account == '7777777777777' || $this->account == '8888888888888' || $this->account == '9999999999999' ){
            return false;
        }

        for ($cont = 0 ; $cont < sizeof($this->account) ; $cont++){
            if (ord($this->account[$cont]) < 48 || ord($this->account[$cont]) > 57) {
                return false;
            }
        }

        $cont1 = 0;

        /*percorre a agencia, e para cada posição, multiplica pela posição correspondente no arranjo weight e armazena na variável  */

        for ($cont = 0;$cont != 4 ; $cont++) {
            $this->temp = $this->temp  + (int)$this->weight[$cont1] * (int)$this->agency[$cont];
            $cont1 = $cont1 + 1;
        }

        $this->account = str_replace('-','',$this->account);
        $this->account = str_replace('.','',$this->account);
        $this->account = str_replace('/','',$this->account);
        $this->account = str_replace(' ', '', $this->account);

        for ($cont = 0 ; $cont != 6 ; $cont++) {
            $this->temp =$this->temp  + (int)$this->weight[$cont1] * (int)$this->account[$cont];

            $cont1 = $cont1 + 1;
        }

        $this->temp = $this->temp  % 11;
        $Digit = $this->account[6];

        if ($this->temp == 10){
            $this->temp = 0;
        }

        if ($Digit != $this->temp)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @return string
     */
    public function getAccountFormatted():string{
        return $this->agency;
    }

    /**
     * @return string
     */
    public function getAgencyFormatted():string{
        return $this->agency;
    }
}