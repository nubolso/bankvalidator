<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 21/09/2016
 * Time: 13:58
 */
namespace test;
use bankvalidator\banks\Bancobrasil;

class BancobrasilTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test construct
     */
    public function testConstruct()
    {
        $test = new Bancobrasil('3659', '273172-X');
        $this->assertEquals($test->agency, '3659');
        $this->assertEquals($test->account, '273172-X');
    }
    /**
     * @param $account
     * @param $newaccount
     * testando o metodo formatted da class bancodobrasil
     * @dataProvider providerTestFormatted
     */
    public function testFormatted($account, $newAccount)
    {
        $test = new Bancobrasil($account, $account);
        $valor = $this->invokeMethod($test, 'formatted', [$account]);
        $this->assertEquals($valor->formatted($account), $newAccount);
    }
    public function providerTestFormatted()
    {
        return [
            ['3659', 3659],
            ['273172-X', 2731720],
            ['1242492-7', 12424927],
            ['3659', 3659],
            ['77461-8', 774618],
            ['1310', 1310],
            ['1051034-6', 10510346],
            ['0642', 642]
        ];
    }
    /**
     * @param $number
     * @param $newNumber
     * @dataProvider providerTestGetFormatted
     */

    public function testGetFormatted($number, $newNumber)
    {
        $test = new Bancobrasil($number, $number);
        $valor = $this->invokeMethod($test, 'getFormatted', [$number]);
        $this->assertEquals($valor, $newNumber);
    }

    public function providerTestGetFormatted()
    {
        return [
            ['3659', '365-9'],
            ['273172-X', '273172-x'],
            ['12424927', '1242492-7'],
            ['3659', '365-9'],
            ['774618', '77461-8'],
            ['1310', '131-x'],
            ['10510346', '1051034-6'],
            ['0642', '64-2']
        ];
    }

/*
        public function testzeroLeft(){
            $test = new Bancobrasil('0324-7','0324-7');
            $valor = $test->zeroLeft('010');
            $test->assertEquals($valor,'010');
        }
        /*
        public function providertestzeroLeft(){
            return[
                ['0324-7','0324-7'],
                ['03659','03659']
            ];
        }


    public function testgetAccountFormatted(){
        $test = new Bancobrasil('0101','0101');
        $valor = $test->getAccountFormatted();
        $this->assertEquals($valor,'010-1');
    }
    public function testgetAgencyFormatted(){
        $test = new Bancobrasil('0101','0101');
        $valor = $test->getAgencyFormatted();
        $this->assertEquals($valor,'010-1');
    }
    */
    /**
     * @param $account
     * @param $sentence
     * @dataProvider providerTestValidateMultiply
     */

    public function testValidateMultiply($account, $sentence)
    {
        $test2 = new Bancobrasil($account, $sentence);
        $account = $test2->validateMultiply($account);
        $this->assertEquals($account, $sentence);
    }

    public function providerTestValidateMultiply()
    {
        return [
            ['0324-7', true],
            ['345-2', false],
            ['3659', false],
            ['273172-X', true],
            ['1242492-7', true],
            ['3659', false],
            ['77461-8', true],
            ['1310', false],
            ['1051034-6', true],
            ['0642', false]
        ];
    }


    /**
     * @param $agency
     * @param $account
     * @param $sentence
     * testa o metodo validate
     * @dataProvider providerTestValidate
     */
    /*$agency, $account, $sentence*/
    public function testValidate($conta, $agencia, $sentencia)
    {
        $test1 = new Bancobrasil($conta, $agencia);
        $conta = $test1->validate();
        $this->assertEquals($conta, $sentencia);
    }

    public function providerTestValidate()
    {
        return [
            [03247, 2867 - 3, false],
            [3659, 3659, false],
            [0546, 11242, false],  // erro

        ];
    }


    public function invokeMethod($objeto, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($objeto));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($objeto, $parameters);
    }
}