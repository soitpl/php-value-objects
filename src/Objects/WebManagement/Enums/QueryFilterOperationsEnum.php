<?php
/**
 * QueryFilterOperationsEnum.php
 *
 * @lastModification 13.01.2020, 19:46
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Objects\WebManagement\Enums;

use soIT\ValueObjects\Traits\IsEnum;

class QueryFilterOperationsEnum
{
    use IsEnum;

    public const EQUALITY = ':';
    public const NEGATION = '!';
    public const GREATER_THAN = '>';
    public const GREATER_EQUAL_THAN = '>:';
    public const LOWER_THAN = '<';
    public const LOWER_EQUAL_THAN = '<:';
    public const LIKE = '~';
}