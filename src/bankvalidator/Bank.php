<?php
namespace bankvalidator;
/**
 * Abstract Class Bank
 * @package bankvalidator
 */
abstract class Bank{
    public $agency;
	public $account;
    protected $weight;

    /**
     * Bank constructor.
     * @param string $agency
     * @param string $account]
     */
    function __construct(string $agency, string $account)
    {
        $this->agency = $agency;
        $this->account = $account;
    }

    /**
     * Converte a agência para inteiro.
     * @return int
     */
    public function getAgencyToInt():int{

        return $this->toInt($this->agency);
    }

    /**
     * Converte o que for passado por parâmetro para inteiro
     * @param string $value
     * @return int
     */
	protected function toInt(string $value):int{
		$converted = str_replace('.','',$value);
        $converted = str_replace('-','',$converted);
        $converted = str_replace('/','',$converted);
        $converted = str_replace(' ', '', $converted);
        return (int)$converted;
	}

    /**
     *
     * Converte o número da conta para inteiro.
     *
     * @return int
     */
	public function getAccountToInt():int{

        return $this->toInt($this->account);
    }

    /**
     *
     * Converte o que for enviado por referência para string, adicionando o ' - '.
     * @return string
     */
    protected function toFormatted(string $Number):string {

        $Number = str_split((string)($this->toInt($Number)));

        $format = ' ';
        $x = count($Number);

        foreach ($Number as $y) {

            if ($x == 1) {
                $format = $format . '-';
            }
            $format = $format . $y;
            $x--;
        }

        return $format;
    }

	/**
    * conta o número de digitos
    * @param int $number
    * @return int quantidade de digitos de um número
    */
    protected function numberDigits(int $number):int
    {
        $parameters = 10;
        $frags = 0;
        while ($number >= 1) {
            $tmp = $number % $parameters;
            $number = ($number - $tmp) / 10;
            $frags = $frags + 1;
        }
        return $frags;
    }
    abstract public function validate():bool;
    abstract public function getAccountFormatted():string;
    abstract public function getAgencyFormatted():string;
}
