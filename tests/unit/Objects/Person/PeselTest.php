<?php
/**
 * PeselTest.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\Person;

use Faker\Generator;
use Faker\Provider\pl_PL\Person;
use PHPUnit\Framework\TestCase;
use soIT\ValueObjects\Exceptions\InvalidArgumentException;
use soIT\ValueObjects\Objects\Person\Localized\PL\Pesel;

class PeselTest extends TestCase
{
    public function testMakeFromString()
    {
        $pesel = $this->getPesel();

        $instance = Pesel::makeFromString($pesel);
        $this->assertEquals($pesel, $instance->toString());
    }

    public function testMakeFromStringNonValid()
    {
        $this->expectException(InvalidArgumentException::class);
        Pesel::makeFromString('12345678901');
    }

    public function testMakeFromStringNon11Digits()
    {
        $this->expectException(InvalidArgumentException::class);
        Pesel::makeFromString('1234567890');
    }

    public function testMakeFromStringNonNumeric()
    {
        $this->expectException(InvalidArgumentException::class);
        Pesel::makeFromString('1234s67890');
    }

    public function testIsEqual()
    {
        $pesel = $this->getPesel();

        $this->assertTrue(Pesel::makeFromString($pesel)->isEqual(Pesel::makeFromString($pesel)));
    }

    public function testIsEqualNonEqual()
    {
        $this->assertFalse(Pesel::makeFromString($this->getPesel())->isEqual(Pesel::makeFromString($this->getPesel())));
    }

    public function testGetSex()
    {
        $pesel = $this->getPesel(null, 'M');

        $instance = Pesel::makeFromString($pesel);
        $this->assertEquals('M', $instance->getSex());

        $pesel = $this->getPesel(null, 'F');

        $instance = Pesel::makeFromString($pesel);
        $this->assertEquals('F', $instance->getSex());
    }

    private function getPesel($birthDate = null, string $sex = null):string
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));

        return $faker->pesel(null, $sex);
    }
}
