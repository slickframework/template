<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * @var \Slick\Template\Template
     */
    private $factory;

    /**
     * @var string
     */
    private $result;

    /**
     * @var \Slick\Template\TemplateEngineInterface
     */
    private $template;

    private $engines = [
        'Twig' => \Slick\Template\Engine\Twig::class
    ];

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I add :path to the list of template paths
     *
     * @param string $path
     */
    public function iAddToTheListOfTemplatePaths($path)
    {
        Slick\Template\Template::addPath(__DIR__."/$path");
    }

    /**
     * @Given I create a factory for :engine engine with no options
     *
     * @param string $engine
     */
    public function iCreateAFactoryForEngineWithNoOptions($engine)
    {
        $this->factory = new Slick\Template\Template(['engine' => $this->engines[$engine]]);
    }

    /**
     * @When I initialize the template
     */
    public function iInitializeTheTemplate()
    {
        $this->template = $this->factory->initialize();
    }

    /**
     * @Then I should have a :engine template engine
     *
     * @param string $engine
     *
     * @throws Exception
     */
    public function iShouldHaveATemplateEngine($engine)
    {
        if (get_class($this->template) !== $this->engines[$engine]) {
            throw new Exception(
                "Expected a {$this->engines[$engine]}, but got ".get_class($this->template)
            );
        }
    }

    /**
     * @Given I append :path to the list of template paths
     *
     * @param string $path
     */
    public function iPrependToTheListOfTemplatePaths($path)
    {
        \Slick\Template\Template::appendPath(__DIR__."/$path");
    }

    /**
     * @Given /^I parse "([^"]*)" and process:$/
     *
     * @param $template
     * @param TableNode $table
     */
    public function iParseAndProcess($template, TableNode $table)
    {
        $data = [];

        foreach ($table->getRows() as $row) {
            $data[$row[0]] = $row[1];
        }

        $this->result = $this->template->parse($template)->process($data);
    }

    /**
     * @Then /^I should get "([^"]*)"$/
     * @param string $expected
     * @throws Exception
     */
    public function iShouldGet($expected)
    {
        if ($this->result !== $expected) {
            throw new Exception("Expected to get {$expected}, but got {$this->result}");
        }
    }

    /**
     * @Given /^I add a custom extension$/
     */
    public function iAddACustomExtension()
    {
        $this->factory->addExtension(new CustomException());
    }
}

class CustomException extends \Slick\Template\Extension\AbstractTwigExtension implements
    \Slick\Template\EngineExtensionInterface
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Custom extension';
    }

    /**
     * Returns a list of filters
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'custom',
                function ($text) {
                    return strtoupper($text);
                }
            )
        ];
    }

}
