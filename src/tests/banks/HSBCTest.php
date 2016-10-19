<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 19/10/2016
 * Time: 14:09
 */

namespace test\banks;
use bankvalidator\banks\HSBC;

class HSBCTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerTestConstruct
     */

    public function testConstruct($agency, $account)
    {
        $valueObj1 = new HSBC($agency,$account);
        $this->assertEquals($valueObj1->Validate(),false);
    }

    /**
     * @dataProvider providerTestConstruct
     */

    public function providerTestConstruct() {
        return [
            ['0416' , '0141'],
            ['34234' ,'34254'],

        ];
    }

    /**
     * @dataProvider providertestvalidatefalse
     */

    public function testvalidatefalse()
    {
        $test = new HSBC('0416', '01208-2');
        $this->assertEquals($test->validate(), false);
    }
}

