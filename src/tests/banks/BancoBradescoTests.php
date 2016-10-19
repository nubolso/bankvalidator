<?php
/**
 * Created by PhpStorm.
 * User: Stefany Fernandes
 * Date: 18/10/2016
 * Time: 12:08
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
            ['6299-5', '337707-5', true],
            ['2309-4', '1637212-9', true]
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