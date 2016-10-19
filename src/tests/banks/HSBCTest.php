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
     * @dataProvider providerTestConstructInValid
     */

    public function testConstructInValid($agency, $account)
    {
        $valueObj1 = new HSBC($agency,$account);
        $this->assertEquals($valueObj1->Validate(),false);
    }

    public function testConstructorValid ($agency,$account)
    {
        $valueObj1 = new HSBC($agency,$account);
        $this->assertEquals($valueObj1->Validate(),true);

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
     * @codeCoverageIgnore
     */
    public function contasProviderInvalid()
    {
        return array(
            array('0189','01017410-0'),
            array('0926','43756391-7'),
            array('0926','437563917'),
            array('0189','01017417-9'),
            array('4292','46698597-3'),
            array('$$+9','53402509-2'),
            array('XXXX','XXXXXXXX-X'),

        );
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

