<?php
/**
 * BankAccount.php
 *
 * @lastModification 30.12.2019, 11:01
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Financial;

use soIT\ValueObjects\Objects\Geography\CountryCode;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

/**
 * Immutable class for IBAN BankAccount
 *
 * @package Core\Shared\ValueObjects\Financial
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 */
final class BankAccount implements ValueObjectInterface
{
    use ValueObjectTrait;

    /**
     * @var string Account number
     */
    public $account;

    /**
     * @var CountryCode Country code
     */
    private $countryCode;

    /**
     * Value object constructor
     *
     * @param string $accountNumber Account number
     * @param CountryCode $countryCode Country Code Object
     */
    public function __construct(string $accountNumber, CountryCode $countryCode)
    {
        $this->countryCode = $countryCode;

        if ($this->isValid($accountNumber)) {
            $this->account = $accountNumber;
        }
    }

    /**
     * Parse native object to ValueObject
     *
     * @param mixed $value Value to parse
     *
     * @return mixed Proper ValueObject
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        $value = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $value));

        return new static(substr($value, 2), CountryCode::makeFromString(substr($value, 0, 2)));
    }

    /**
     * @return mixed Output native value of object
     */
    public function toString():string
    {
        return $this->account;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param mixed $valueObject Value to check
     *
     * @return bool
     */
    public function isEqual(ValueObjectInterface $valueObject):bool
    {
        // TODO: Implement isEqual() method.
    }

    /**
     * Is string valid for VO
     *
     * @param string $accountNumber
     *
     * @return bool
     */
    public function isValid(string $accountNumber):bool
    {
        if (!ctype_digit($accountNumber) || strlen($accountNumber) < 20) {
            return false;
        }

        $accountNumber = $this->countryCode->toString().$accountNumber;
        $accountNumber = substr($accountNumber, 4).substr($accountNumber, 0, 4);

        $accountNumberLength = strlen($accountNumber);

        $accountNormalize = '';

        for ($i = 0; $i < $accountNumberLength; $i++) {
            $accountNormalize .= $this->getSign($accountNumber[$i]);
        }

        $mod = 0;
        $accountNumberLength = strlen($accountNormalize);

        for ($i = 0; $i < $accountNumberLength; $i = $i + 6) {
            $mod = (int)($mod.substr($accountNormalize, $i, 6)) % 97;
        }

        return $mod === 1;
    }

    /**
     * Get proper char to validate number.
     * If $char is digit return $char, if is letter return digit according to ASCII code of $char (ASCII -55)
     *
     * @param string $char
     *
     * @return string
     */
    private function getSign(string $char):string
    {
        return is_numeric($char) ? $char : ord($char) - 55;
    }
}
