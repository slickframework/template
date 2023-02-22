<?php

/**
 * This file is part of slick/template package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Template\Utils;

/**
 * Text Utilities class
 *
 * @package Slick\Template\Utils
 */
abstract class Text
{

    /**
     * Truncates the value string with the provided length
     *
     * If the string length is lower the the desired truncate length
     * the value is returned intact.
     *
     * If the string is bigger then the provided length then it will
     * be cut and the a terminator will be added to the end of the string.
     *
     * If you specify $preserve arg as true the world will be preserved
     * when cutting the string and the cut will occur on the next available
     * space character counting from the provided length.
     *
     * @param string $value
     * @param int $length
     * @param string $terminator
     * @param bool $preserve
     *
     * @return string The truncate string
     */
    public static function truncate(
        string $value,
        int $length = 80,
        string $terminator = "\n",
        bool $preserve = false
    ): string {
        $length = $preserve
            ? static::preserveBreakpoint($value, $length)
            : $length;
        if (mb_strlen($value) > $length) {
            $value = rtrim(mb_substr($value, 0, $length)).
                $terminator;
        }
        return $value;
    }

    /**
     * Wraps a string to a given number of characters using a string
     * break character.
     *
     * @param string $value  The input string.
     * @param int $length The number of characters at which the string
     *                       will be wrapped.
     * @param string $break  The line is broken using the optional
     *                       break parameter.
     * @param bool $cut    If the cut is set to TRUE, the string is always
     *                       wrapped at or before the specified width. So if
     *                       you have a word that is larger than the given
     *                       width, it is broken apart. When FALSE the function
     *                       does not split the word even if the width is
     *                       smaller than the word width.
     *
     * @return string Returns the given string wrapped at the specified length.
     */
    public static function wordwrap(
        string $value,
        int $length = 75,
        string $break = "\n",
        bool $cut = false
    ): string {
        return wordwrap($value, $length, $break, $cut);
    }

    /**
     * Check truncate length to avoid split a word
     *
     * @param string $value
     * @param int $length
     *
     * @return int
     */
    private static function preserveBreakpoint(string $value, int $length): int
    {
        if (strlen($value) <= $length) {
            return $length;
        }
        $breakpoint = mb_strpos($value, ' ', $length);
        $length = $breakpoint;
        if (false === $breakpoint) {
            $length = mb_strlen($value);
        }
        return $length;
    }
}
