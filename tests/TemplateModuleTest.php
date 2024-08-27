<?php
/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Slick\Template;

use Dotenv\Dotenv;
use Prophecy\PhpUnit\ProphecyTrait;
use Slick\Template\TemplateModule;
use PHPUnit\Framework\TestCase;

class TemplateModuleTest extends TestCase
{

    use ProphecyTrait;

    public function testServices(): void
    {
        $module = new TemplateModule();
        $this->assertIsArray($module->services());
    }

    public function testDescription(): void
    {
        $module = new TemplateModule();
        $this->assertEquals(
            "Allows integration and usage of a template engine of your choice.",
            $module->description()
        );
    }

    public function testSettings(): void
    {
        $env = $this->prophesize(Dotenv::class)->reveal();
        $module = new TemplateModule();
        $this->assertEquals(
            [
                'debug' => true,
                'charset' => 'utf-8',
                'cache' => false,
                'strict_variables' => true,
                'optimizations' => -1
            ],
            $module->settings($env)['template']['options']
        );
    }

}
