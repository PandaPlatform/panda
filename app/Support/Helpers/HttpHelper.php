<?php

namespace App\Support\Helpers;

use Panda\Support\Helpers\ArrayHelper;

/**
 * Class HttpHelper
 * @package App\Support\Helpers
 */
class HttpHelper
{
    const METHOD_POST = 'post';
    const METHOD_GET = 'get';
    const METHOD_PUT = 'put';
    const METHOD_PATCH = 'patch';
    const METHOD_DELETE = 'delete';
    const METHOD_DELETE_WITH_CONTENT = 'delete_with_content';
    const METHOD_ALIAS_CREATE = 'create';
    const METHOD_ALIAS_UPDATE_WITH_CONTENT = 'update_with_content';
    const METHOD_ALIAS_UPDATE_WITHOUT_CONTENT = 'update_without_content';
    const METHOD_ALIAS_SUCCESS = "success";

    /**
     * @var array
     */
    protected static $successStatusCodes = [
        self::METHOD_POST => 201,
        self::METHOD_GET => 200,
        self::METHOD_PUT => 200,
        self::METHOD_PATCH => 200,
        self::METHOD_DELETE => 204,
        self::METHOD_DELETE_WITH_CONTENT => 200,
        self::METHOD_ALIAS_CREATE => 201,
        self::METHOD_ALIAS_UPDATE_WITH_CONTENT => 200,
        self::METHOD_ALIAS_UPDATE_WITHOUT_CONTENT => 204,
        self::METHOD_ALIAS_SUCCESS => 200,
    ];

    /**
     * @param string $method
     *
     * @return int
     */
    public static function getStatusCodeOnSuccess($method)
    {
        return ArrayHelper::get(self::$successStatusCodes, strtolower($method), 200);
    }
}
