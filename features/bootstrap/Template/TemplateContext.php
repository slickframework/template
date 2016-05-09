<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Template;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as Assert;
use Slick\I18n\Translator;
use Slick\Template\Template;
use Slick\Template\TemplateEngineInterface;

/**
 * Step definitions for slick/template package
 *
 * @behatContext
 */
class TemplateContext extends \AbstractContext implements
    Context, SnippetAcceptingContext
{

    /** @var Template */
    protected $factory;

    /** @var TemplateEngineInterface */
    protected $engine;

    /** @var string */
    protected $output;

    public function __construct()
    {
        Translator::getInstance()
            ->setLocale('pt_PT')
            ->setType(Translator::TYPE_PHP_ARRAY)
            ->setBasePath(__DIR__.'/i18n');
    }

    /**
     * @Given /^I instantiate a template factory$/
     */
    public function createTemplateFactory()
    {
        $this->factory = new Template();
    }

    /**
     * @Given /^I add "([^"]*)" to template locations$/
     *
     * @param $path
     */
    public function addLocation($path)
    {
        $path = __DIR__.'/'.$path;
        Template::addPath($path);
    }

    /**
     * @When /^I run initialize on the template factory$/
     */
    public function iRunInitializeOnTheTemplateFactory()
    {
        $this->engine = $this->factory->initialize();
    }

    /**
     * @Then /^I should get a "([^"]*)" object$/
     */
    public function iShouldGetAInstanceOfType($type)
    {
        Assert::assertInstanceOf($type, $this->engine);
    }

    /**
     * @When /^I parse "([^"]*)" template file$/
     *
     * @param string $fileName
     */
    public function iParseTemplateFile($fileName)
    {
        $this->engine->parse($fileName);
    }

    /**
     * @Given /^I process:$/
     *
     * @param TableNode $table
     */
    public function iProcess(TableNode $table)
    {
        $data = [];
        $hash = $table->getHash();
        foreach ($hash as $row) {
            $data[$row['key']] = $row['value'];
        }
        $this->output = $this->engine->process($data);
    }

    /**
     * @Then /^the output should be "([^"]*)";$/
     *
     * @param string $expected
     */
    public function theOutputShouldBe($expected)
    {
        $expected = str_replace('\n', "\n", $expected);
        Assert::assertEquals($expected, $this->output);
    }

    /**
     * @Given /^I set default option "([^"]*)" to "([^"]*)"$/
     * 
     * @param string $option
     * @param string $value
     */
    public function iSetDefaultOptionTo($option, $value)
    {
        Template::setDefaultOptions($option, $value);
    }

    /**
     * @Then the output should contain:
     * 
     * @param PyStringNode $string
     */
    public function theOutputShouldContain(PyStringNode $string)
    {
        Assert::assertContains($string->getRaw(), $this->output);
    }

}
