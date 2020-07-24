<?php
/**
 * Password.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Miscellaneous;

use soIT\ValueObjects\ValueObjectInterface;

class Password implements ValueObjectInterface
{
    /**
     * @var string Plain password
     */
    private $password;
    /**
     * @var int Minimum password length
     */
    private $minLength;
    /**
     * @var bool Should password has at leas one number
     */
    private $shouldHaveNumber;
    /**
     * @var bool Should password has at least one lowercase
     */
    private $shouldHaveLowercase;
    /**
     * @var bool Should password have at least one special char
     */
    private $shouldHaveSpecial;
    /**
     * @var bool Should password have at least one uppercase letter
     */
    private $shouldHaveUppercase;

    /**
     * Password constructor.
     *
     * @param string $password
     * @param array $rules
     */
    public function __construct(string $password, array $rules = [])
    {
        $this->password = $password;
        $this->setRules($rules);
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
        return new Password($value);
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
        return $this->toString() === $valueObject->toString();
    }

    /**
     * @return mixed Output native value of object
     */
    public function toString():string
    {
        return $this->password;
    }

    /**
     * Is string valid for VO
     *
     * @param string $value
     *
     * @return bool
     */
    public static function isValid(string $value):bool
    {
        // TODO: Implement validate() method.
    }

    /**
     * Check is password correct with rules
     */
    public function isCorrect():bool
    {
        return $this->hasProperLength() &&
               $this->hasNumber() &&
               $this->hasLowercase() &&
               $this->hasUppercase() &&
               $this->hasSymbol();
    }

    /**
     * Set password rules
     *
     * @param array $rules
     */
    public function setRules(array $rules):void
    {
        $this->minLength = (bool)($rules['min_length'] ?? 0);
        $this->shouldHaveNumber = (bool)($rules['number'] ?? false);
        $this->shouldHaveLowercase = (bool)($rules['lowercase_char'] ?? false);
        $this->shouldHaveUppercase = (bool)($rules['uppercase_char'] ?? false);
        $this->shouldHaveSpecial = (bool)($rules['special_char'] ?? false);
    }

    /**
     * Check that password is longer than min length
     * @return bool
     */
    private function hasProperLength():bool
    {
        return strlen($this->password) >= $this->minLength;
    }

    /**
     * Has password digit
     *
     * @return bool
     */
    private function hasNumber():bool
    {
        return !$this->shouldHaveNumber ? : $this->hasPattern("#[0-9]+#");
    }

    /**
     * Has password lowercase
     *
     * @return bool
     */
    private function hasLowercase():bool
    {
        return !$this->shouldHaveLowercase ? : $this->hasPattern("#[a-z]+#");
    }

    /**
     * Has password uppercase letter
     *
     * @return bool
     */
    private function hasSymbol():bool
    {
        return !$this->shouldHaveSpecial ? : $this->hasPattern("#\W+#");
    }

    /**
     * Has password uppercase letter
     *
     * @return bool
     */
    private function hasUppercase():bool
    {
        return !$this->shouldHaveUppercase ? : $this->hasPattern("#[A-Z]+#");
    }

    /**
     * Check password has pattern
     *
     * @param string $pattern
     *
     * @return bool
     */
    private function hasPattern(string $pattern):bool
    {
        return preg_match($pattern, $this->password);
    }
}
