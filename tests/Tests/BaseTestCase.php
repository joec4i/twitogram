<?php
namespace Twitogram\Tests;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Call protected method
     * @param string $object
     * @param string $method
     * @param array $arguments
     */
    protected function callProtected($object, $method, $arguments = array())
    {
        $class = new \ReflectionClass($object);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $arguments);
    }

    /**
     * Loads mock result from the data directory and returns as a json-decoded array
     * @param string $filename
     */
    protected function getMockResult($filename)
    {
        $file = __DIR__ . '/../data/' . $filename;
        return json_decode(file_get_contents($file));
    }

}