<?php

namespace Nagoya\Doukaku;

class DoukakuTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Doukaku
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new Doukaku;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\Nagoya\Doukaku\Doukaku', $actual);
    }

    /**
     * @expectedException \Nagoya\Doukaku\Exception\LogicException
     */
    public function testException()
    {
        throw new Exception\LogicException;
    }
}
