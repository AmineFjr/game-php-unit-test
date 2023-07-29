<?php

use PHPUnit\Framework\TestCase;

class gameTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }


    public function testTrue()
    {
        $this->assertTrue(true);
    }

    /**
     * @before
     */
    public function testFalse()
    {
        $this->assertFalse(false);
    }

    public function tearUp()
    {
    }
}
