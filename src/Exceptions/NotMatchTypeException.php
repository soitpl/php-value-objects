<?php
/**
 * NotMatchTypeException.php
 *
 * @lastModification 22.07.2020, 00:35
 * @author Rafał Tadaszak <r.tadaszak@soit.pl>
 * @copyright soIT.pl 2018 - 2020
 * @url http://www.soit.pl
 */

namespace soIT\ValueObjects\Exceptions;

use Exception;
use soIT\ValueObjects\Traits\ValueObjectTrait;
use soIT\ValueObjects\ValueObjectInterface;

class NotMatchTypeException extends Exception
{
    /**
     * @param ValueObjectInterface|ValueObjectTrait $object
     */
    public function __construct(ValueObjectInterface $object)
    {
        parent::__construct(
            sprintf('Not matching object type. Argument should be "%s" class type', get_class($object))
        );
    }
}
