<?php
/**
 * Created by PhpStorm.
 * User: Stefany Fernandes
 */

namespace test\banks;
use bankvalidator\banks\Bradesco;
use tests\BankTest;


class Test extends \PHPUnit_Framework_TestCase
{


    /**
     * @param string $agencia
     * @param string $conta
     * @param bool $expected
     *
     * @dataProvider providerValidateAgencyAndAccount
     */
    public function testValidate(string $agencia, string $conta, bool $expected) {
        $objB = new Bradesco($agencia, $conta);
        $this->assertEquals($objB->validate(), $expected);
    }

    /**
     * @param string $agencia
     * @param string $conta
     * @param bool $expected
     *
     * @dataProvider providerValidateAgencyAndAccount
     */
    public function testValidadeAccount(string $agencia, string $conta, bool $expected) {
        $objAcc = new Bradesco($agencia, $conta);
        $this->assertEquals($objAcc->validateAccount(), $expected);
    }


    /**
     * @param string $agencia
     * @param string $conta
     * @param bool $esperado
     *
     * @dataProvider providerValidateAgencyAndAccount
     */
    public function testValidateAgency(string $agencia, string $conta,bool $expected) {
        $obj1 = new Bradesco($agencia, $conta);
        $this->assertEquals($obj1->validateAgency(), $expected);

    }

    /**
     * @return array
     * provider para os testes de agencia e conta
     */
    public function providerValidateAgencyAndAccount(){
        return [
            ['0635-1', '0020173-1', true],
            ['635-1', '20173-1', true],
            ['6299-5', '337707-5', true],
            ['2309-4', '1637212-9', true],
            ['1245-9', '1369712-4', true],
            ['1804-0', '0000725-0', true],
            ['3578-5', '1990606-0', true],
            ['0635-7', '0020173-9', false],
            ['635-9', '20173-7', false],
            ['6299-2', '337707-0', false],
            ['62990-2', '3377007-0', false],
            ['2309-0', '1637212-2', false],
            ['1245-1', '1369712-6', false],
            ['3578-3', '1990606-1', false]
        ];
    }

    /**
     * @param $agencia
     * @param $conta
     * @param $esperado
     *
     * @dataProvider providerGetFormatted
     *
     */
    public function testGetFormatted(string $agencia, string $conta, string $expected){
        $obj1 = new Bradesco($agencia, $conta);
        $this->assertEquals($obj1->getFormatted(), $expected);
    }

    /**
     * @return array com os valores que serão usados para teste
     */
    public function providerGetFormatted() {
        return [
            ['0635-1', '20173-1', '635-1 20173-1'],
            ['635-1', '0020173-1', '635-1 20173-1'],
            ['2309-4', '1637212-9', '2309-4 1637212-9']
        ];
    }


}