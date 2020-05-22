<?php

namespace MeusFeeds\Usuarios\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    public function setUp() : void
    {
        parent::setUp();

        error_reporting(E_ALL);
    }
}
