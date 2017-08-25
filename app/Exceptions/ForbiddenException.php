<?php

namespace App\Exceptions;

/**
 * Class ForbiddenException
 *
 * The purpose of this exception is to explain that a an action cannot be performed
 * because of reasons different from user authentication.
 * For example:
 * - credits have expired
 * - feature is disabled etc.
 * A 403 Forbidden code should be returned.
 *
 * @package App\Exceptions
 */
class ForbiddenException extends \Exception implements \Throwable
{
}
