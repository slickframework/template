<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Template\Extension;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Slick\Template\Extension\I18n;

/**
 * I18n Twig extension test case
 *
 * @package Slick\Tests\Template\Extension
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class I18nTest extends TestCase
{

    /**
     * @var I18n|MockObject
     */
    protected $extension;

    protected function setUp()
    {
        parent::setUp();
        $this->extension = $this->getMockBuilder(
            'Slick\Template\Extension\I18n'
        )
            ->setMethods(['translate', 'translatePlural'])
            ->getMock();
    }

    /**
     * Should return the extension name
     * @test
     */
    public function extensionName()
    {
        $this->assertEquals('I18n extension', $this->extension->getName());
    }

    /**
     * Should call the translate method
     * @test
     */
    public function translate()
    {
        /** @var \Twig_SimpleFunction $function */
        $function = $this->extension->getFunctions()[0];
        $this->assertEquals('translate', $function->getName());
        $this->extension->expects($this->once())
            ->method('translate')
            ->with('test')
            ->willReturn('teste');
        $this->assertEquals(
            'teste',
            call_user_func_array($function->getCallable(), ['test'])
        );
    }

    /**
     * Should call the translatePlural method
     * @test
     */
    public function translatePlural()
    {
        /** @var \Twig_SimpleFunction $function */
        $function = $this->extension->getFunctions()[1];
        $this->assertEquals('transPlural', $function->getName());
        $this->extension->expects($this->once())
            ->method('translatePlural')
            ->with('test', 'tests', 2)
            ->willReturn('testes');
        $this->assertEquals(
            'testes',
            call_user_func_array($function->getCallable(), ['test','tests', 2])
        );
    }
}
