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
        $valueObj1 = new HSBC($agency, $account);
        $this->assertEquals($valueObj1->validate(),false);
    }

    public function providerTestConstructInValid()
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
     * @dataProvider providerTestConstructValid
     */

    public function testConstructorValid($agency, $account)
    {
        $valueObj1 = new HSBC($agency, $account);
        $this->assertEquals($valueObj1->validate(), false);

    }

    public function providerTestConstructValid() {
        return [
			array('1116','261958-3'),
            array('1970','750683-3'),
            array('2400','567286-1'),
            array('1116','851521-6'),
            array('0499','785993-0'),

        ];
    }

    /**
     * @dataProvider providerGetAccountFormatted
     */

    public function testGetAccountFormatted($var) {

        $obj = new HSBC('0000', $var);
        $verification = $obj->getAccountFormatted();
        $this->assertTrue($verification[7] == '-');

    }

    public function providerGetAccountFormatted()
    {
        return [
            array('7436452'),
            array('7468056'),
            array('6811618'),
            array('8515216'),
            array('7859930'),
        ];
    }

}

