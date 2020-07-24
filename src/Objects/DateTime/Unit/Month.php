<?php
/**
 * Month.php
 *
 * @lastModification 22.07.2020, 00:37
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\DateTime\Unit;

use DateTime;
use Exception;
use soIT\ValueObjects\ValueObjectInterface;

final class Month extends UnitAbstract implements ValueObjectInterface
{
    public const RANGE = ['min' => 1, "max" => 12];
    private const OUTPUT_FORMATS = ['F', 'm', 'M', 'n'];

    /**
     * @param string $format
     *
     * @return mixed Output native value of object
     * @throws Exception
     */
    public function toString(string $format = 'm'):string
    {
        if (!$this->checkIsValidFormat($format)) {
            $this->throwInvalidArgumentException($format, "Unknown output month string formatter");
        }

        return (new DateTime())->setDate(date('Y'), $this->value, date('d', strtotime(date('Y').'-01-01')))->format
        (
            $format
        );
    }

    /**
     * @param string $format
     *
     * @return bool
     */
    private function checkIsValidFormat(string $format):bool
    {
        return in_array($format, self::OUTPUT_FORMATS);
    }
}
