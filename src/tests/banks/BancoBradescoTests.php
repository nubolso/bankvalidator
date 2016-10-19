<?php
/**
 * Created by PhpStorm.
 * User: Stefany Fernandes
 * Date: 18/10/2016
 * Time: 12:08
 */

namespace test\banks;
use bankvalidator\banks\Bradesco;


class Test extends \PHPUnit_Framework_TestCase
{


    /**
     * @param string $agencia
     * @param string $conta
     * @param bool $esperado
     *
     * @dataProvider providerValidateAgency
     */
    public function testValidateAgency(string $agencia, string $conta,bool $esperado) {
        $obj1 = new Bradesco($agencia, $conta);
        $this->assertEquals($obj1->validateAgency(), $esperado);

    }


    public function providerValidateAgency(){
        return [
            ['0635-1', '20173-1', true],
            ['635-1', '0020173-1', true],
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
    public function testGetFormatted(string $agencia, string $conta, string $esperado){
        $obj1 = new Bradesco($agencia, $conta);
        $this->assertEquals($obj1->getFormatted(), $esperado);
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