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
    public function services(): array
    {
        $servicesFile = dirname(__DIR__) . '/config/services.php';
        return importSettingsFile($servicesFile);
    }

    public function settings(Dotenv $dotenv): array
    {
        $defaultSettings = importSettingsFile(dirname(__DIR__) . '/config/settings.php');
        $userSettings = ['template' => importSettingsFile(APP_ROOT . '/config/modules/template.php')];
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

    public function onEnable(array $context = []): void
    {
        $path = APP_ROOT . '/templates';
        if (file_exists($path)) {
            return;
        }

        mkdir($path, 0755, true);
    }
}
