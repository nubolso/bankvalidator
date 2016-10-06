<?php

namespace banks\Itau;

use bankvalidator\Bank;

class Itau extends Bank{

    private $number;

    public function __construct($agency, $account)
    {
        parent::__construct($agency, $account);
        $this->number = $this->toInt($agency).$this->toInt($account);
    }

    public function getAccountFormatted():string{
        // TODO: Implement getAccountFormatted() method.
        return '';
    }

    public function getAgencyFormatted():string{
        // TODO: Implement getAgencyFormatted() method.
        return '';
    }

    public function validate():bool{
        // TODO: Implement validate() method.

        return 0;
    }

}