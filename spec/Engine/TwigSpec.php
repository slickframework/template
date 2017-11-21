<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Slick\Template\Engine;

use Slick\Template\Engine\Twig;
use PhpSpec\ObjectBehavior;
use Slick\Template\TemplateEngineInterface;
use Twig_Environment;

/**
 * TwigSpec specs
 *
 * @package spec\Slick\Template\Engine
 */
class TwigSpec extends ObjectBehavior
{
    private $options = [
        'autoEscape' => false
    ];

    function let(Twig_Environment $twigEnvironment, template $template)
    {
        $template->render(['foo' => 'bar'])->willReturn('test bar');
        $this->beConstructedWith($this->options, $twigEnvironment);
    }

    function its_a_template_engine()
    {
        $this->shouldBeAnInstanceOf(TemplateEngineInterface::class);
    }

    function it_is_initializable_with_a_list_of_options()
    {
        $this->shouldHaveType(Twig::class);
    }

    function it_has_a_list_of_options()
    {
        $this->options()->shouldHaveKeyWithValue('autoEscape', false);
    }

    function it_has_a_source_engine(Twig_Environment $twigEnvironment)
    {
        $this->getSourceEngine()->shouldBe($twigEnvironment);
    }

    function it_can_accept_a_list_of_template_locations()
    {
        $locations = ['./', './templates'];
        $this->setLocations($locations)->shouldBe($this->getWrappedObject());
    }

    function it_parses_a_source_template(Twig_Environment $twigEnvironment, template $template)
    {
        $source = 'test.twig';
        $twigEnvironment->load($source)->shouldBeCalled()->willReturn($template);
        $this->parse($source)->shouldBe($this->getWrappedObject());
    }

    function it_renders_a_previously_loaded_template(Twig_Environment $twigEnvironment, template $template)
    {
        $source = 'test.twig';
        $twigEnvironment->load($source)->willReturn($template);
        $this->parse($source);
        $this->process(['foo' => 'bar'])->shouldBe('test bar');
        $template->render(['foo' => 'bar'])->shouldHaveBeenCalled();
    }
}


interface template
{
    public function render(array $data);
}