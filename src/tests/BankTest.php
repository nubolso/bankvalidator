<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 21/09/2016
 * Time: 13:58
 */
namespace src\tests;
use src\bankvalidator\banks\Bancobrasil;

class BankTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test construct
     */
    public function testconstruct(){
        $test = new Bancobrasil('3659','273172-X');
        $account = $test->getAccountFormatted();
        $agency = $test->getAgencyFormatted();
        $this->assertEquals($account, '3659');
        $this->assertEquals($agency, '273172-X');
    }



    /**
     * @param $account
     * @param $newaccount
     * testando o metodo formatted da class bancodobrasil
     * @dataProvider providertestformatted
     */
    public function testformatted($account,$newaccount){
        $test = new Bancobrasil('','');
        $valor = $this->invokeMethod($test,'formatted',[$account]);
        $this->assertEquals($valor,$newaccount);
    }
    public function providertestformatted(){
        return[
            ['3659',3659],
            ['273172-X',2731720],
            ['1242492-7',12424927],
            ['3659',3659],
            ['77461-8',774618],
            ['1310',1310],
            ['1051034-6',10510346],
            ['0642',0642]
        ];
    }


    /**
     * @param $number
     * @param $newnumber
     * testando o metodo getformatted
     * @dataProvider providertestgetFormatted
     */
    public function testgetFormatted($number,$newnumber){
        $test = new Bancobrasil('','');
        $valor = $this->invokeMethod($test,'getFormatted',[$number]);
        $this->assertEquals($valor,$newnumber);
    }
    public function providertestgetFormatted(){
        return[
            ['3659','3659'],
            ['2731720','273172-X'],
            ['1242492-7','12424927'],
            ['3659','3659'],
            ['77461-8','774618'],
            ['1310','1310'],
            ['1051034-6','10510346'],
            ['0642','0642']
        ];
    }


    /**
     * @param $account
     * @param $resultado
     * @dataProvider providertestzeroLeft
     */
    public function testzeroLeft($account, $resultado){
        $test = new Bancobrasil('','');
        $valor = $test->zeroLeft($account);
        $test->assertEquals($valor, $resultado);
    }

    public function providertestzeroLeft(){
        return[
            ['324-7','0324-7'],
            ['3659','3659'],
            ['3659','03659'],
            ['1310','01310'],
            ['0642','0642']

        ];
    }


    /**
     * @param $account
     * @param $sentence
     * @dataProvider providertestvalidatemultiply
     */
    public function testvalidatemultiply($account, $sentence)
    {
        $test2 = new Bancobrasil('', '');
        $account = $test2->validateMultiply($account);
        $this->assertEquals($account, $sentence);
    }

    public function providertestvalidatemultiply(){
        return [
            ['0324-7',false],
            ['345-2',false],
            ['3659',true],
            ['273172-X',true],
            ['1242492-7',true],
            ['3659',true],
            ['77461-8',true],
            ['1310',true],
            ['1051034-6',true],
            ['0642',true]
        ];
    }



    /**
     * @param $agency
     * @param $account
     * @param $sentence
     * testa o metodo validate
     * @dataProvider providertestvalidate
     */
    public function testvalidate($agency, $account, $sentence){
        $test1 = new Bancobrasil('','');
        //$account = $test1->validate();
        $agencia = $test1->validateMultiply($agency);
        $conta = $test1->validateMultiply($account);
        $test1->assertEquals($agencia, $conta, $sentence);
    }
    public function providertestvalidate(){
        return [
            ['03247','2867-3', false],
            ['2434-2','43343-2', false],
            ['3659','3659',true],
            ['2731720','273172-X',true],
            ['1242492-7','12424927',true],
            ['3659','3659',true],
            ['77461-8','774618',true],
            ['1310','1310',true],
            ['1051034-6','10510346',true],
            ['0642','0642',true]

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