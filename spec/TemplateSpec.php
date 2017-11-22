<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Slick\Template;

use Slick\Template\Engine\Twig;
use Slick\Template\Exception\InvalidArgumentException;
use Slick\Template\Template;
use PhpSpec\ObjectBehavior;

/**
 * TemplateSpec specs
 *
 * @package spec\Slick\Template
 */
class TemplateSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(['engine' => Template::ENGINE_TWIG, 'options' => ['debug' => true]]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Template::class);
    }

    function it_creates_a_template_engine()
    {
        $this->initialize()->shouldBeAnInstanceOf(Twig::class);
    }

    function it_throws_exception_for_classes_that_do_not_implement_template_engine()
    {
        $this->beConstructedWith(['engine' => \stdClass::class]);
        $this->shouldThrow(InvalidArgumentException::class)
            ->duringInstantiation();

    }


}