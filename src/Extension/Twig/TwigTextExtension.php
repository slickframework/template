<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Extension\Twig;

use Slick\Template\Extension\IpsumLorenGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * TwigTextExtension
 *
 * @package Slick\Template\Extension\Twig
 */
final class TwigTextExtension extends AbstractExtension
{
    /**
     * Retrieves the filters of this extension.
     *
     * @return array<TwigFilter> The filters.
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate']),
            new TwigFilter('wordwrap', [$this, 'wordwrap'])
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('generateWords', [$this, 'generateWords']),
            new TwigFunction('generateSentences', [$this, 'generateSentences']),
            new TwigFunction('generateParagraphs', [$this, 'generateParagraphs']),
        ];
    }

    /**
     * Generate random words using IpsumLorenGenerator.
     *
     * @param int $count The number of words to generate. Default is 1.
     * @return string The generated words.
     */
    public function generateWords(int $count = 1): string
    {
        $generator = new IpsumLorenGenerator();
        return $generator->words($count);
    }

    /**
     * Generates a specified number of sentences using IpsumLorenGenerator.
     *
     * @param int $count The number of sentences to generate (default is 1).
     * @return string The generated sentences.
     */
    public function generateSentences(int $count = 1): string
    {
        $generator = new IpsumLorenGenerator();
        return $generator->sentences($count);
    }

    /**
     * Generates a specified number of paragraphs using IpsumLorenGenerator.
     *
     * @param int $count The number of paragraphs to generate (default is 1).
     * @return string The generated paragraphs.
     */
    public function generateParagraphs(int $count = 1): string
    {
        $generator = new IpsumLorenGenerator();
        return $generator->paragraphs($count);
    }

    /**
     * Truncates a given string to a specified length and appends a terminator.
     *
     * @param string $value The string to truncate.
     * @param int $len The maximum length of the truncated string. Default is 75.
     * @param string $ter The terminator to append to the truncated string. Default is "...".
     * @return string The truncated string.
     */
    public function truncate(string $value, int $len = 75, string $ter = "..."): string
    {
        $truncated = $value;
        $length = $this->preserveBreakpoint($value, $len);
        if (mb_strlen($value) > $length) {
            $truncated = rtrim(mb_substr($value, 0, $length)). $ter;
        }
        return $truncated;
    }

    /**
     * Wrap a string into lines of a specified length.
     *
     * @param string $value The input string to be wrapped.
     * @param int $len The number of characters at which the string will be wrapped.
     * @param string $break The character used to break the lines.
     * @return string The wrapped string.
     */
    public function wordwrap(string $value, int $len = 75, string $break = "\n"): string
    {
        return wordwrap($value, $len, $break);
    }

    /**
     * Returns the length to preserve the breakpoint for truncating a given string.
     *
     * @param string $value The string to calculate the breakpoint for.
     * @param int $length The maximum length of the truncated string.
     * @return int The length to preserve the breakpoint.
     */
    private function preserveBreakpoint(string $value, int $length): int
    {
        if (strlen($value) <= $length) {
            return $length;
        }

        $breakpoint = mb_strpos($value, ' ', $length);
        $length = false === $breakpoint ? mb_strlen($value) : $breakpoint;
        return (int) $length;
    }
}
