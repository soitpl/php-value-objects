<?php
/**
 * Pesel.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Person\Localized\PL;

use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\ValueObjectInterface;

class Pesel implements ValueObjectInterface
{
    /**
     * @var string PESEL number
     */
    private $pesel;
    /**
     * @var string
     */
    private $sex;

    /**
     * Pesel constructor.
     *
     * @param string $pesel
     */
    private function __construct(string $pesel)
    {
        if ($this->isValid($pesel)) {
            $this->setPesel($pesel);
        } else {
            throw new InvalidArgumentException(self::class, $pesel);
        }
    }

    /**
     * @inheritDoc
     */
    public function isEqual(ValueObjectInterface $pesel):bool
    {
        return $this->toString() === $pesel->toString();
    }

    /**
     * @inheritDoc
     */
    public function toString():string
    {
        return $this->pesel;
    }

    /**
     * @inheritDoc
     */
    public static function makeFromString(string $value):ValueObjectInterface
    {
        return new self($value);
    }

    /**
     * @return string
     */
    public function getSex():string
    {
        return $this->sex;
    }

    /**
     * @param string $pesel
     *
     * @return bool
     */
    public function isValid(string $pesel):bool
    {
        if (strlen($pesel) != 11 || !is_numeric($pesel)) {
            return false;
        }

        $this->setSex($pesel[9] % 2 ? 'M' : 'F');

        $weights = [1, 3, 7, 9];
        $cs = 0;
        for ($i = 0; $i <= 9; $i++) {
            $cs = ($cs + $pesel[$i] * $weights[$i % 4]) % 10;
        }
        $ck = (10 - $cs) % 10;

        return ($pesel[10] == $ck);
    }

    /**
     * @param string $sex
     */
    private function setSex(string $sex):void
    {
        $this->sex = $sex;
    }

    /**
     * @param string $pesel
     */
    private function setPesel(string $pesel):void
    {
        $this->pesel = $pesel;
    }
}