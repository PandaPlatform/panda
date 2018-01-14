<?php

namespace App\Support\Helpers;

use ReflectionClass;
use ReflectionProperty;

/**
 * Class DataTypeInspector
 * @package App\Support\Helpers
 */
class DataTypeInspector
{
    /**
     * @param mixed $object
     *
     * @return array|null
     */
    public static function getObjectMethodsNames($object)
    {
        // Check if object is class
        $class = get_class($object);
        if (!$class) {
            return null;
        }

        return get_class_methods($class);
    }

    /**
     * @param mixed $object
     *
     * @return array
     */
    public static function getObjectConstants($object)
    {
        // Normalize class
        $class = is_string($object) ? $object : get_class($object);

        // Create Reflection
        $reflection = new ReflectionClass($class);

        return $reflection->getConstants();
    }

    /**
     * @param mixed $object
     *
     * @return null|ReflectionProperty[]
     */
    public static function getObjectProperties($object)
    {
        // Check if object is valid
        if (!$object) {
            return null;
        }

        // Create Reflection
        $reflection = new ReflectionClass($object);

        return $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
    }

    /**
     * @param mixed  $class
     * @param string $interface
     *
     * @return bool
     */
    public static function implementsInterface($class, $interface)
    {
        $interfaces = class_implements($class);
        foreach ($interfaces as $if) {
            if ($if == $interface) {
                return true;
            }
        }

        return false;
    }
}
