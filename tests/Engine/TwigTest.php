<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Template\Engine;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Template\Engine\Twig;

/**
 * Twig test case
 *
 * @package Test\Template\Twig
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class TwigTest extends TestCase
{

    /**
     * @var Twig
     */
    protected $engine;

    /**
     * @var array
     */
    private $options = [
        'debug' => false,
        'autoEscape' => false,
        'strictVariables' => true,
        'autoReload' => true,
        'cache' => false,
    ];

    /**
     * creates the SUT twig object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->engine = new Twig($this->options);
        $this->engine->setLocations([dirname(__DIR__).'/templates']);
    }

    /**
     * Should create a Twig_Loader_Filesystem object if ist not set yet
     * @test
     */
    public function createFilesystemLoader()
    {
        $this->assertInstanceOf('Twig_Loader_Filesystem', $this->engine->loader);
    }

    /**
     * Should create a Twig_Environment object if ist not set yet
     * @test
     */
    public function createTwigEnvironment()
    {
        $this->engine->loader = $this->getLoaderMock();
        $this->assertInstanceOf('\Twig_Environment', $this->engine->twigEnvironment);
    }

    /**
     * Should parse and create a twig template object
     * @test
     */
    public function parseTemplate()
    {
        $twig = $this->getTwigEnvironmentMock(['loadTemplate']);
        $twig->expects($this->once())
            ->method('loadTemplate')
            ->with('index.html.twig')
            ->willReturn($this->getTwigTemplateMock());
        $this->engine->twigEnvironment = $twig;
        $this->assertSame(
            $this->engine,
            $this->engine->parse('index.html.twig')
        );
    }

    /**
     * Should throw an exception if any error occur
     * @test
     * @expectedException \Slick\Template\Exception\ParserException
     */
    public function parseTemplateException()
    {
        $twig = $this->getTwigEnvironmentMock(['loadTemplate']);
        $twig->expects($this->once())
            ->method('loadTemplate')
            ->with('index.html.twig')
            ->willThrowException(new \Exception('Error!'));
        $this->engine->twigEnvironment = $twig;
        $this->engine->parse('index.html.twig');
    }

    /**
     * Should use the engine previously parsed to process the provided data
     * @test
     */
    public function processData()
    {
        $data = array();
        $template = $this->getTwigTemplateMock(
            ['render', 'getTemplateName', 'doDisplay']
        );
        $template->expects($this->once())
            ->method('render')
            ->with($data)
            ->willReturn('Ok');
        $this->engine->template = $template;
        $this->assertEquals('Ok', $this->engine->process($data));
    }

    /**
     * Should throw an exception when any error occur processing data
     * @test
     * @expectedException \Slick\Template\Exception\ParserException
     */
    public function processDataException()
    {
        $data = array();
        $template = $this->getTwigTemplateMock(
            ['render', 'getTemplateName', 'doDisplay']
        );
        $template->expects($this->once())
            ->method('render')
            ->with($data)
            ->willThrowException(new \Exception('Error!'));
        $this->engine->template = $template;
        $this->engine->process($data);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Twig_Loader_Filesystem
     */
    protected function getLoaderMock()
    {
        $loader = $this->getMockBuilder('Twig_Loader_Filesystem')
            ->getMock();
        return $loader;
    }

    /**
     * @param array $methods
     * @return \PHPUnit_Framework_MockObject_MockObject|\Twig_Template
     */
    protected function getTwigTemplateMock($methods = [])
    {
        $template = $this->getMockBuilder('\Twig_Template')
            ->setMethods($methods)
            ->setConstructorArgs([$this->getTwigEnvironmentMock()])
            ->getMock();
        return $template;
    }

    /**
     * @param array $methods
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Twig_Environment
     */
    protected function getTwigEnvironmentMock($methods = [])
    {
        $environment = $this->getMockBuilder('\Twig_Environment')
            ->setMethods($methods)
            ->getMock();
        return $environment;
    }

}
