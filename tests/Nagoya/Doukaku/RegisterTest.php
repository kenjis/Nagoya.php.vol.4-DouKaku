<?php

namespace Nagoya\Doukaku;

/**
 * @group App
 */
class RegisterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Register
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Register(1, 2);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function test_AddCustomer_and_CalcCustomerCount()
    {
        $this->object->addCustomers('3');
        $this->object->addCustomers('1');
        $this->object->addCustomers('x');
        $test = $this->object->calcCustomerCount();
        $this->assertEquals(5, $test);
    }

    public function testProcess()
    {
        $this->object->addCustomers('3');
        $this->object->addCustomers('1');
        $this->object->addCustomers('x');

        $this->object->process();
        $test = $this->object->calcCustomerCount();
        $this->assertEquals(3, $test);

        $this->object->process();
        $test = $this->object->calcCustomerCount();
        $this->assertEquals(1, $test);
    }

}
