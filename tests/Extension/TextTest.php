<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Template\Extension;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Template\Engine\Twig;
use Slick\Template\Extension\Text;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Slick\Template\TemplateEngineInterface;

/**
 * Text extension for twig engine test case
 *
 * @package Slick\Tests\Template\Extension
 * @author  Filipe Silva <silva.filipe@gmail.com>
 */
class TextTest extends TestCase
{

    /**
     * @var Text
     */
    protected $extension;

    /**
     * Sets the SUT text object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->extension = new Text();
    }

    /**
     * Clears SUT for next test
     */
    protected function tearDown()
    {
        $this->extension = null;
        parent::tearDown();
    }

    /**
     * Should add the extension to the source template engine
     * @test
     */
    public function updateEngine()
    {
        $twigEnv = $this->getTwigEnvironmentMock(['addExtension']);
        $engine = $this->getTwigEngineMock(['getSourceEngine']);

        $twigEnv->expects($this->once())
            ->method('addExtension')
            ->with($this->extension);

        $engine->expects($this->once())
            ->method('getSourceEngine')
            ->willReturn($twigEnv);

        $this->extension->update($engine);
    }

    /**
     * Should call 1st filter on the extension
     * @test
     */
    public function truncate()
    {
        /** @var \Twig_SimpleFilter $filter */
        $filter = $this->extension->getFilters()[0];
        $callable = $filter->getCallable();
        $this->assertEquals(
            '123',
            call_user_func_array($callable, ['123', 4])
        );
    }

    /**
     * Should call 1st filter on the extension
     * @test
     */
    public function wordwrap()
    {
        /** @var \Twig_SimpleFilter $filter */
        $filter = $this->extension->getFilters()[1];
        $callable = $filter->getCallable();
        $this->assertEquals(
            "123\n4",
            call_user_func_array($callable, ['123 4', 3])
        );
    }

    /**
     * Should pass only on Twig or Twig extended objects
     */
    public function testApplicableEngine()
    {
        $this->assertTrue(
            $this->extension->appliesTo($this->getTwigEngineMock())
        );
        $this->assertFalse(
            $this->extension->appliesTo($this->getGenericEngine())
        );
    }

    /**
     * Should return 'Text utilities extension'
     */
    public function testName()
    {
        $this->assertEquals(
            'Text utilities extension',
            $this->extension->getName()
        );
    }

    /**
     * @param array $methods
     * @return MockObject|Twig
     */
    protected function getTwigEngineMock($methods = [])
    {
        $class = 'Slick\Template\Engine\Twig';
        $engine = $this->getMockBuilder($class)
            ->setMethods($methods)
            ->getMock();
        return $engine;
    }

    /**
     * @return MockObject|TemplateEngineInterface
     */
    protected function getGenericEngine()
    {
        return $this->getMock('Slick\Template\TemplateEngineInterface');
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
