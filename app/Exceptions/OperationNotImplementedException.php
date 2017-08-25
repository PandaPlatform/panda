<?php

namespace App\Exceptions;

/**
 * Class OperationNotAvailableException
 *
 * The purpose of this exception is to explain that a an action cannot be performed
 * on a specific object or service.
 * A 501 Not Implemented code should be returned, if propagated to a Controller.
 *
 * @package App\Exceptions
 */
class OperationNotImplementedException extends \Exception implements \Throwable
{
}
