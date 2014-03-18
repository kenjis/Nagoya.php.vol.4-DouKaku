<?php

namespace Nagoya\Doukaku;

/**
 * @group App
 */
class RegisterCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RegisterCollection
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $registerList = [
            1 => 2,
            2 => 7,
            3 => 3,
            4 => 5,
            5 => 2,
        ];
        $registerSelector = new RegisterSelector;
        $this->object = new RegisterCollection($registerList, $registerSelector);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testAddCustomers()
    {
        $this->object->addCustomers('3');
        $test = $this->object->getStatus();
        $expected = [ 1 => 3, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $this->assertEquals($expected, $test);
    }

    public function testGetStatus()
    {
        $test = $this->object->getStatus();
        $expected = [ 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
        $this->assertEquals($expected, $test);
    }

}
