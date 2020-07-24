<?php
/**
 * CountryCode.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Geography;

use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Exceptions\NotMatchTypeException;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

/**
 * Implementation of alpha2 CountryCode
 *
 * @package Core\Shared\ValueObjects\Geography
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 */
final class CountryCode implements ValueObjectInterface
{
    use ValueObjectTrait;

    /**
     * @var string Country code
     */
    protected $countryCode;

    /**
     * CountryCode constructor.
     *
     * @param string $countryCode
     */
    private function __construct(string $countryCode)
    {
        if ($this->isValid($countryCode)) {
            $this->countryCode = $countryCode;
        } else {
            throw new InvalidArgumentException(
                __CLASS__,
                $countryCode,
                "Country code should have only too upper letters"
            );
        }
    }

    /**
     * Parse native country code to constructor
     *
     * @param string $value Value to parse
     *
     * @return self Proper ValueObject
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        return new self($value);
    }

    /**
     * @return mixed Output native value of object
     */
    public function toString():string
    {
        return $this->countryCode;
    }

    /**
     * Check is object value equal with defined in object
     *
     * @param ValueObjectInterface $countryCode
     *
     * @return bool
     * @throws NotMatchTypeException
     */
    public function isEqual(ValueObjectInterface $countryCode):bool
    {
        return $this->hasEqualType($countryCode) && $this->get() === $countryCode->get();
    }

    /**
     * Return country code
     *
     * @return string
     */
    public function get():string
    {
        return $this->countryCode;
    }

    /**
     * Valid country code is proper
     *
     * @param string $countryCode
     *
     * @return bool
     */
    private function isValid(string $countryCode):bool
    {
        return strlen($countryCode) == 2 && ctype_upper($countryCode);
    }
}
