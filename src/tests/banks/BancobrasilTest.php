<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 21/09/2016
 * Time: 13:58
 */
namespace test\banks;
use bankvalidator\banks\BancoBrasil;
class BancoBrasilTest extends \PHPUnit_Framework_TestCase
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
     * @param $sentence
     * @dataProvider providerTestValidateMultiply
     */
    public function testValidateMultiply($account, $sentence)
    {
        $test = new Bancobrasil($account, $sentence);
        $resul = $this->invokeMethod($test,'validateMultiply',[$account]);
        $this->assertEquals($resul, $sentence);
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
     * @param $number
     * @param $newNumber
     * @dataProvider providerTestZeroLeft
     */
    public function testZeroLeft($agency, $account,$retorno){
        $test = new Bancobrasil($agency,$account);
        $resul = $this->invokeMethod($test,'zeroLeft',[$account]);
        $this->assertEquals($resul,$retorno);
    }
    public function providerTestZeroLeft(){
        return[
            ['3205','59251X','59251-0'],
            ['0922','03659','0365-9'],
            ['0922','000001','00000-1'],
            ['0922','220048-x','220048-0']
        ];
    }

    /**
     * @param $number
     * @param $newNumber
     * @dataProvider providerTestGetAccountFormatted
     */
    public function testGetAccountFormatted($number, $newNumber){
        $test = new Bancobrasil($number,$number);
        $this->assertEquals($test->getAccountFormatted(),$newNumber);
    }
    public function providerTestGetAccountFormatted(){
        return[
            ['03247','0324-7'],
            ['00468','0046-8'],
            ['248673','24867-3'],
            ['220048-x','220048-0']
        ];
    }

    /**
     * @param $number
     * @param $newNumber
     * @dataProvider providerTestGetAgencyFormatted
     */
    public function testGetAgencyFormatted($number,$newNumber){
        $test = new Bancobrasil($number,$number);
        $this->assertEquals($test->getAgencyFormatted(),$newNumber);
    }
    public function providerTestGetAgencyFormatted(){
        return[
            ['03247','0324-7'],
            ['00468','0046-8'],
            ['248673','24867-3'],
            ['220048-x','220048-0']
        ];
    }

    /**
     * @param $agency
     * @param $account
     * @param $sentence
     * @dataProvider providerTestValidate
     */
    public function testValidate($agency, $account,  $sentence)
    {
        $test = new Bancobrasil($agency, $account);
        $this->assertEquals($test->validate(), $sentence);
    }
    public function providerTestValidate()
    {
        return [
            ['03247', '24867-3', true],
            ['03247', '238538', true],
            ['2458','24589',false],
            ['25689','12458',false],
            ['0922','1014553-2',true],
            ['1132','2262371',false],
            ['4691','114099-X',false],
            ['3071','1088796-2',false],
            ['0087','1118423-X',false],
            ['3403','220599-8',false],
            ['2289','211653-7',false],
            ['4535','48468-7',false],
            ['0358','1288404-9',false],
            ['4041','21001-3',false],
            ['4041','21001-3',false],
            ['4628','82341-4',false],
            ['2925','255256-6',true]
        ];
    }


    /**
     * @param $agencia
     * @param $conta
     * @param $sentece
     * @dataProvider  providertestValidateAgency
     */
    public function testValidateAgency($agencia,$conta,$sentece){
        $obj = new BancoBrasil($agencia,$conta,$sentece);
        $resul = $this->invokeMethod($obj, 'validateAgency',[]);
        $this->assertEquals($resul,$sentece);
    }
    public function providertestValidateAgency(){
             return [
                 ['03247', '24867-3', true],
                 ['03247', '238538', true],
                 ['2458','24589',false],
                 ['25689','12458',false]
             ];
    }


    /**
     * @param $agencia
     * @param $conta
     * @param $sentece
     * @dataProvider providertestValidateAccount
     */
    public function testValidateAccount($agencia,$conta,$sentece){
        $obj = new BancoBrasil($agencia,$conta,$sentece);
        $resul = $this->invokeMethod($obj, 'validateAccount',[]);
        $this->assertEquals($resul,$sentece);
    }
    public function providertestValidateAccount(){
        return [
            ['03247', '24867-3', true],
            ['03247', '238538', true],
            ['2458','24589',true],
            ['25689','12458',false]
        ];
    }


    /**
     * @param $agencia
     * @param $conta
     * @param $sentenca
     * @dataProvider providertestLimitedNumbersAgency
     */
    public function testLimitedNumbersAgency($agencia,$conta,$sentenca){
       $obj = new BancoBrasil($agencia,$conta);
        $resul = $this->invokeMethod($obj, 'limitedNumbersAgency',[]);
        $this->assertEquals($resul,$sentenca);
    }
    public function providertestLimitedNumbersAgency(){
        return [
            ['03247', '24867-3', true],
            ['03247', '238538', true],
            ['2458','24589',true],
            ['25689','12458',true]
        ];
    }


    /**
     * @param $agencia
     * @param $conta
     * @param $sentenca
     * @dataProvider providertestLimitedNumbersAccount
     */
    public function testLimitedNumbersAccount($agencia,$conta,$sentenca){
        $obj = new BancoBrasil($agencia,$conta);
        $resul = $this->invokeMethod($obj, 'limitedNumbersAgency',[]);
        $this->assertEquals($resul,$sentenca);
    }
    public function providertestLimitedNumbersAccount(){
        return [
            ['03247', '24867-3', true],
            ['03247', '238538', true],
            ['2458','24589',true],
            ['25689','12458',true]
        ];
    }


    public function invokeMethod($objeto, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($objeto));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($objeto, $parameters);
    }

    /*
     * @param $account
     * @param $newAccount
     * @dataProvider providerTestFormatted

    public function testFormatted($account, $newAccount)
    {
    $test = new Bancobrasil($account, $account);
    $this->assertEquals($test->formatted($account), $newAccount);
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
     * */
    /*
     * @param $number
     * @param $newNumber
     * @dataProvider providerTestGetFormatted

    public function testGetFormatted($number, $newNumber)
    {
    $test = new Bancobrasil($number, $number);
    $this->assertEquals($test->getFormatted($number), $newNumber);
    }
    public function providerTestGetFormatted()
    {
    return [
    ['3659', '365-9'],
    ['273172-X', '273172-0'],
    ['12424927', '1242492-7'],
    ['3659', '365-9'],
    ['774618', '77461-8'],
    ['1310', '131-0'],
    ['10510346', '1051034-6'],
    ['0642', '64-2']
    ];
    }
    /*


    /**
     * @param $account
     * @param $agency
     * @param $sentence
     * @dataProvider providerTestValidate
     */
}




