<?php
class HelloWorldTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // ToDo: Setup
    }

    public function testHelloWorld()
    {
        $helloWorld = 'Hello World';
        $this->assertEquals('Hello World', $helloWorld);
    }
}
