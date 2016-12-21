<?php
/*
 * IFG 2016, alunos: Fernando Augusto e Matheus Dias*/

declare(strict_types=1);

namespace bankvalidator\banks;

use bankvalidator\Bank;


/**
 *
 * Classe validadora de contas Santander
 *
 * Class Santander
 * @package Validator\Bank
 *
 */class Santander extends Bank{
    /**
     * Santander constructor, cria um objeto com a finalidade de atribuir os valores de agencia e conta passados por parametros.
     * @param string $agency
     * @param string $account
     */
    public function __construct($agency,$account)
    {
        $this->weight = array(9,7,3,1,9,7,1,3,1,9,7,3);
        parent::__construct($agency,$account);
    }

    /**
     * Validate, validador de contas e agencias de banco Santander
     * @return bool
     */
    public function Validate():bool{
        $agencylocal = $this->agency;
        $accountlocal = $this->account;
        $accountlocal = str_replace('-','',$accountlocal);
        $account = $agencylocal.$accountlocal;
        $sum = 0;
        $temporary = 0;
        while ($temporary != 13){
            if (ord($account[$temporary]) < 48 || ord($account[$temporary]) > 57)
            {
                return false;
            }
            $temporary = $temporary + 1;
        }

        if ($account == '0000000000000' || $account == '1111111111111' || $account == '2222222222222' || $account == '3333333333333' || $account == '4444444444444' ||
            $account == '5555555555555' || $account == '6666666666666' || $account == '7777777777777' || $account == '8888888888888' || $account == '9999999999999' ){
            return false;
        }
        $i = 0;
        while ($i != 12){
            $tomporary1 = $this->weight[$i];
            $temporary2 = $account[$i];
            $temporary3 = (($tomporary1 * $temporary2)%10);
            $sum = $sum + $temporary3;
            $i = $i + 1;
        }
        $rest = $sum % 10;
        if ($rest == 0)
        {
            $Digit = 0;
        }
        else
        {
            $Digit = 10 - $rest;
        }
        $tester= $account[12];
        if ($Digit != $tester)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * getAccountFormatted formata número da conta.
     * @return string
     */
    public function getAccountFormatted():string{
        $Bank = $this->account;
        $Bank = str_replace('-','',$Bank);
        return $Bank[0].$Bank[1].$Bank[2].$Bank[3].$Bank[4].$Bank[5].$Bank[6].$Bank[7].'-'.$Bank[8];
    }

    /**
     * getAgengyFormatted formata o número da agencia.
     * @return string
     */
    public function getAgencyFormatted():string{
        $Bank = $this->agency;
        $Bank = str_replace('-','',$Bank);
        return $Bank[0].$Bank[1].$Bank[2].$Bank[3];
    }

}