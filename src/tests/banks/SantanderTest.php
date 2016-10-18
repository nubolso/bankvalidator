<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Matheus
 * Date: 27.set.2016
 * Time: 14:47
 */
namespace tests\banks;
use bankvalidator\banks\Santander;
class SantanderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider contasProviderInvalid
     */
    public function testConstructorInValid ($agency,$account)
    {
        $valueObj1 = new Santander($agency,$account);
      //  $test = $valueObj1->getAgencyToInt();
        $this->assertEquals($valueObj1->Validate(),false);
    }

    /**
     * @dataProvider contasProviderValid
     */
    public function testConstructorValid ($agency,$account)
    {
        $valueObj1 = new Santander($agency,$account);
      //  $valueObj1->getAccountToInt();
        $this->assertEquals($valueObj1->Validate(),true);

    }
    /**
     * @codeCoverageIgnore
     */
    public function contasProviderInvalid()
    {
        return array(
            array('4609','53492509-0'),
            array('4609','534925090'),
            array('0090','0094609 53492509-0'),
            array('7746','09 53492509-0'),
            array('$$+9','53402509-2'),
            array('XXXX','XXXXXXXX-X'),
            array('abcd','53492509-2'),
            array('53492509-2','4609'),
        );
    }
    /**
     * @codeCoverageIgnore
     */
    public function contasProviderValid()
    {
        return array(
            array('0189','01017410-0'),
            array('0926','43756391-7'),
            array('0926','437563917'),
            array('0189','01017417-9'),
            array('4292','46698597-3'),
        );
    }
}