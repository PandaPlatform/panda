<?php

namespace App\Exceptions;

/**
 * Class RecordNotFoundException
 *
 * The purpose of this exception is to explain that a record (either database or something else)
 * is not found and a 404 Not Found code should be returned.
 *
 * @package App\Exceptions
 */
class RecordNotFoundException extends \Exception implements \Throwable
{
}
