<?php

declare(strict_types=1);

namespace banks\Itau;

use bankvalidator\Bank;

/**
 * Class validator accounts and agency's Itau
 * Class Itau
 * @package banks\Itau
 */
class Itau extends Bank{

    public function __construct($agency, $account)
    {
        parent::__construct($agency, $account);
    }

    public function getAccountFormatted():string
    {
        // TODO: Implement getAccountFormatted() method.
        return 0;
    }

    public function getAgencyFormatted():string
    {
        // TODO: Implement getAgencyFormatted() method.
        return 0;
    }

    public function validate():bool
    {
        // TODO: Implement validate() method.
        return 0;
    }

}