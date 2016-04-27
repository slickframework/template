<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Template;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Template\Engine\Twig;
use Slick\Template\EngineExtensionInterface;
use Slick\Template\Template;
use Slick\Template\TemplateEngineInterface;

/**
 * Template engine factory test case
 *
 * @package Slick\Tests\Template
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class TemplateTest extends TestCase
{

    /**
     * @var Template
     */
    protected $template;

    /**
     * Creates the SUT template factory object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->template = new Template();
    }

    /**
     * Clean up before next test
     */
    protected function tearDown()
    {
        $this->template = null;
        parent::tearDown();
    }

    /**
     * Should add path to the beginning of the list
     * @test
     */
    public function addPath()
    {
        $paths = Template::getPaths();
        $expected = array_merge([__DIR__], $paths);

        Template::addPath(__DIR__);
        $this->assertEquals($expected, Template::getPaths());
    }

    /**
     * Should add path to the end of the list
     * @test
     */
    public function appendPath()
    {
        $paths = Template::getPaths();
        $expected = array_merge($paths, [dirname(__DIR__)]);
        Template::appendPath(dirname(__DIR__));
        $this->assertEquals($expected, Template::getPaths());
    }

    /**
     * Should throw an exception
     * @test
     * @expectedException \Slick\Template\Exception\InvalidArgumentException
     */
    public function addInvalidExtension()
    {
        $this->template->addExtension('stdClass');
    }

    /**
     * Should validate class as an extension and add it to the list of
     * available extensions
     * @test
     */
    public function addExtension()
    {
        $className = 'Slick\Tests\Template\MyExtension';
        $this->assertSame(
            $this->template,
            $this->template->addExtension($className)
        );
        $extensions = array_keys($this->template->getExtensions());
        $this->assertTrue(in_array($className, $extensions));
    }
    
    public function testStaticExtensionRegister()
    {
        $className = 'Slick\Tests\Template\MyExtension';
        $template = Template::register($className);
        $extensions = array_keys($template->extensions);
        $this->assertTrue(in_array($className, $extensions));
    }

    /**
     * Should create the engine, pass the paths and apply the extensions
     * @test
     */
    public function initialize()
    {
        $extName = 'Slick\Tests\Template\MyExtension';
        $otherExt = 'Slick\Tests\Template\OtherExtension';
        MyExtension::$updated = false;
        OtherExtension::$updated = false;

        $this->template->setExtensions([
            $extName => null,
            $otherExt => new OtherExtension()
        ]);
        $engine = $this->template->initialize();
        $this->assertTrue($engine instanceof Twig);
        $this->assertTrue(MyExtension::$updated);
        $this->assertTrue(OtherExtension::$updated);
    }

    /**
     * Should throw an exception
     * @test
     * @expectedException \Slick\Template\Exception\InvalidArgumentException
     */
    public function initializeInvalidEngine()
    {
        $this->template->engine = 'unknown';
        $this->template->initialize();
    }

}

/**
 * Test extension  MyExtension
 *
 * @package Slick\Tests\Template
 */
class MyExtension implements EngineExtensionInterface
{

    public static $updated = false;

    /**
     * Updates the engine with this extension
     *
     * @param TemplateEngineInterface $engine
     *
     * @return void
     */
    public function update(TemplateEngineInterface $engine)
    {
        static::$updated = true;
    }

    /**
     * Check if this extension is applicable to provided engine object
     *
     * @param TemplateEngineInterface $engine
     *
     * @return bool True if this extension applies to provided engine object
     *      or false otherwise
     */
    public function appliesTo(TemplateEngineInterface $engine)
    {
        return true;
    }
}

class OtherExtension extends MyExtension
{
    public static $updated = false;
}