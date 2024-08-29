<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template;

use Dotenv\Dotenv;
use Slick\ModuleApi\Infrastructure\AbstractModule;
use Slick\ModuleApi\Infrastructure\FrontController\WebModuleInterface;
use function Slick\ModuleApi\importSettingsFile;
use function Slick\ModuleApi\mergeArrays;

/**
 * TemplateModule
 *
 * @package Slick\Template
 */
final class TemplateModule extends AbstractModule implements WebModuleInterface
{
    const CONFIG_MODULES_TEMPLATE_PHP = '/config/modules/template.php';
    private static string $defaultSettings = <<<EOS
<?php

/**
 * This file is part of template module
 */

return [
    'paths' => [dirname(__DIR__, 2) . '/templates'],
    'options' => [
        'debug' => isset(\$_ENV["APP_ENV"]) ? \$_ENV["APP_ENV"] == 'develop' : false,
    ],
    'framework' => 'bulma',
    'theme' => 'sandstone'
];
 
EOS;

    public function services(): array
    {
        $servicesFile = dirname(__DIR__) . '/config/services.php';
        return importSettingsFile($servicesFile);
    }

    /**
     * Get the merged settings from default and user configurations.
     *
     * @param Dotenv $dotenv The Dotenv instance.
     * @return array<string, mixed> The merged settings array.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function settings(Dotenv $dotenv): array
    {
        $defaultSettings = importSettingsFile(dirname(__DIR__) . '/config/settings.php');
        $templateConfigPath = APP_ROOT . self::CONFIG_MODULES_TEMPLATE_PHP;

        if (!file_exists($templateConfigPath)) {
            return $defaultSettings;
        }

        $userSettings = ['template' => importSettingsFile($templateConfigPath)];
        $userSettings['template']['paths'] = array_merge(
            $userSettings['template']['paths'],
            $defaultSettings['template']['paths']
        );

        return mergeArrays($defaultSettings, $userSettings);
    }

    public function description(): ?string
    {
        return "Allows integration and usage of a template engine of your choice.";
    }

    /**
     * Handles the "onEnable" event.
     *
     * @param array<string, mixed> $context An optional array of context data.
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function onEnable(array $context = []): void
    {
        $path = APP_ROOT . '/templates';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $settingsFile = APP_ROOT . self::CONFIG_MODULES_TEMPLATE_PHP;
        if (file_exists($settingsFile)) {
            return;
        }

        file_put_contents($settingsFile, self::$defaultSettings);
    }

    public function onDisable(array $context = []): void
    {
        if (!$context['purge']) {
            return;
        }

        $settingsFile = APP_ROOT . self::CONFIG_MODULES_TEMPLATE_PHP;
        if (file_exists($settingsFile)) {
            unlink($settingsFile);
        }
    }
}
