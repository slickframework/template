<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Template\Engine;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Template\Engine\AbstractEngine;

/**
 * Abstract Engine test case
 *
 * @package Slick\Tests\Template\Engine
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AbstractEngineTest extends TestCase
{

    /**
     * @var AbstractEngine
     */
    protected $engine;

    /**
     * Creates the SUT test
     */
    protected function setUp()
    {
        parent::setUp();
        $this->engine = $this->getMockForAbstractClass(
            'Slick\Template\Engine\AbstractEngine'
        );
    }

    /**
     * Should return self instance as it is already the engine object
     * @test
     */
    public function tryInitialization()
    {
        $this->assertSame($this->engine, $this->engine->initialize());
    }
}
