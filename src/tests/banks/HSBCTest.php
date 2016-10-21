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

    public function testConstructInValid()
    {
        $valueObj1 = new HSBC('0189','01017410-0');
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

    public function testConstructorValid ()
    {
        $valueObj1 = new HSBC('0499','743645-2');
        $this->assertEquals($valueObj1->validate(),true);

    }

    public function providerTestConstructValid() {
        return [
			array('0499','743645-2'),
            array('2400','746805-6'),
            array('0813','681161-8'),
            array('1116','851521-6'),
            array('0499','785993-0'),

        ];
    }

    public function getAgencyFormatted (string $agency ,string  $account){
        $valueObj1 = new HSBC($agency , $account);
        $agency = str_replace(' ','',$agency);
        $agency = str_replace('.','',$agency);
        $agency = str_replace('/','',$agency);
        $this->assertEquals($valueObj1->getAgencyFormatted() , $agency);
    }

    public function providerGetAgencyFormatted()
    {
        return [
            array('0499','743645 2'),
            array('2400','746805/6'),
            array('0813','681161/8'),
            array('1116','851521-6'),
            array('0499','785993.0'),
            ];
    }

    public function getAccountFormatted (string $agency ,string  $account){
        $valueObj1 = new HSBC($agency , $account);
        $account = str_replace(' ','-',$account);
        $account = str_replace('.','-',$account);
        $account = str_replace('/','-',$account);
        $this->assertEquals($valueObj1->getAccountFormatted() , $account);
    }

    public function providerGetAccountFormatted()
    {
        return [
            array('0499','743645 2'),
            array('2400','746805/6'),
            array('0813','681161/8'),
            array('1116','851521-6'),
            array('0499','785993.0'),
        ];
    }

}

