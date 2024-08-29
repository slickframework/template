<?php

/**
 * This file is part of template
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Slick\Template\Extension;

/**
 * IpsumLorenGenerator
 *
 * @package Slick\Template\Extension
 */
final class IpsumLorenGenerator
{
    /**
     * Whether we should be starting the string with "Lorem ipsum..."
     *
     * @access private
     * @var    mixed
     */
    private mixed $first = true;

    /**
     * A lorem ipsum vocabulary of sorts. Not a complete list as I'm unsure if
     * a complete list exists and if so, where to get it.
     *
     * @access private
     * @var    array<string>
     */
    private array $words = [
        // Lorem ipsum...
        'lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit',

        // and the rest of the vocabulary
        'a', 'ac', 'accumsan', 'ad', 'aenean', 'aliquam', 'aliquet', 'ante',
        'aptent', 'arcu', 'at', 'auctor', 'augue', 'bibendum', 'blandit',
        'class', 'commodo', 'condimentum', 'congue', 'consequat', 'conubia',
        'convallis', 'cras', 'cubilia', 'curabitur', 'curae', 'cursus',
        'dapibus', 'diam', 'dictum', 'dictumst', 'dignissim', 'dis', 'donec',
        'dui', 'duis', 'efficitur', 'egestas', 'eget', 'eleifend', 'elementum',
        'enim', 'erat', 'eros', 'est', 'et', 'etiam', 'eu', 'euismod', 'ex',
        'facilisi', 'facilisis', 'fames', 'faucibus', 'felis', 'fermentum',
        'feugiat', 'finibus', 'fringilla', 'fusce', 'gravida', 'habitant',
        'habitasse', 'hac', 'hendrerit', 'himenaeos', 'iaculis', 'id',
        'imperdiet', 'in', 'inceptos', 'integer', 'interdum', 'justo',
        'lacinia', 'lacus', 'laoreet', 'lectus', 'leo', 'libero', 'ligula',
        'litora', 'lobortis', 'luctus', 'maecenas', 'magna', 'magnis',
        'malesuada', 'massa', 'mattis', 'mauris', 'maximus', 'metus', 'mi',
        'molestie', 'mollis', 'montes', 'morbi', 'mus', 'nam', 'nascetur',
        'natoque', 'nec', 'neque', 'netus', 'nibh', 'nisi', 'nisl', 'non',
        'nostra', 'nulla', 'nullam', 'nunc', 'odio', 'orci', 'ornare',
        'parturient', 'pellentesque', 'penatibus', 'per', 'pharetra',
        'phasellus', 'placerat', 'platea', 'porta', 'porttitor', 'posuere',
        'potenti', 'praesent', 'pretium', 'primis', 'proin', 'pulvinar',
        'purus', 'quam', 'quis', 'quisque', 'rhoncus', 'ridiculus', 'risus',
        'rutrum', 'sagittis', 'sapien', 'scelerisque', 'sed', 'sem', 'semper',
        'senectus', 'sociosqu', 'sodales', 'sollicitudin', 'suscipit', 'slick',
        'suspendisse', 'taciti', 'tellus', 'tempor', 'tempus', 'tincidunt',
        'torquent', 'tortor', 'tristique', 'turpis', 'ullamcorper', 'ultrices',
        'ultricies', 'urna', 'ut', 'varius', 'vehicula', 'vel', 'velit',
        'venenatis', 'vestibulum', 'vitae', 'vivamus', 'viverra', 'volutpat',
        'vulputate',
    ];

    /**
     * Generates a single word of lorem ipsum.
     *
     * @access public
     * @return string generated lorem ipsum word
     */
    public function word(): string
    {
        return $this->words();
    }

    /**
     * Generates words of lorem ipsum.
     *
     * @access public
     * @param  integer $count how many words to generate
     * @return array<string>   array of generated lorem ipsum words
     */
    public function wordsArray(int $count = 1): array
    {
        $wordCount = 0;
        $words = [];

        // Shuffles and appends the word list to compensate for count
        // arguments that exceed the size of our vocabulary list
        while ($wordCount < $count) {
            $shuffle = true;

            while ($shuffle) {
                $this->shuffle();

                // Checks that the last word of the list and the first word of
                // the list that's about to be appended are not the same
                if (!$wordCount || $words[$wordCount - 1] != $this->words[0]) {
                    $words      = array_merge($words, $this->words);
                    $wordCount  = count($words);
                    $shuffle    = false;
                }
            }
        }

        return array_slice($words, 0, $count);
    }

    /**
     * Sentences Array
     *
     * Generates an array of lorem ipsum sentences.
     *
     * @access public
     * @param integer $count how many sentences to generate
     * @return array<string> generated lorem ipsum sentences
     */
    public function sentencesArray(int $count = 1): array
    {
        $sentences = array();

        for ($i = 0; $i < $count; $i++) {
            $sentences[] = $this->wordsArray($this->gauss(24.46, 5.08));
        }

        $this->punctuate($sentences);
        return $sentences;
    }

    /**
     * Generates sentences of lorem ipsum.
     *
     * @access public
     * @param  int $count how many sentences to generate
     * @return string  string of generated lorem ipsum sentences
     */
    public function sentences(int $count = 1): string
    {
        return implode(" ", $this->sentencesArray($count));
    }

    /**
     * Generates a full sentence of lorem ipsum.
     *
     * @access public
     * @return string generated lorem ipsum sentence
     */
    public function sentence(): string
    {
        return $this->sentences();
    }


    /**
     * Generates words of lorem ipsum.
     *
     * @access public
     * @param  integer $count how many words to generate
     * @return string A string containing the given number of words
     */
    public function words(int $count = 1): string
    {
        return implode(" ", $this->wordsArray($count));
    }

    /**
     * Generates an array of lorem ipsum paragraphs.
     *
     * @access public
     * @param  int $count how many paragraphs to generate
     * @return array<string>   generated lorem ipsum paragraphs
     */
    public function paragraphsArray(int $count = 1): array
    {
        $paragraphs = array();

        for ($i = 0; $i < $count; $i++) {
            $paragraphs[] = $this->sentences($this->gauss(5.8, 1.93));
        }

        return $paragraphs;
    }

    /**
     * Generates paragraphs of lorem ipsum.
     *
     * @access public
     * @param  integer $count how many paragraphs to generate
     * @return string   string of generated lorem ipsum paragraphs
     */
    public function paragraphs(int $count = 1): string
    {
        return implode("\n", $this->paragraphsArray($count));
    }

    /**
     * Generates a full paragraph of lorem ipsum.
     *
     * @access public
     * @return string generated lorem ipsum paragraph
     */
    public function paragraph(): string
    {
        return $this->paragraphs();
    }

    /**
     * Shuffle
     *
     * Shuffles the words, forcing "Lorem ipsum..." at the beginning if it is
     * the first time we are generating the text.
     *
     * @access private
     * @return void
     */
    private function shuffle(): void
    {
        if ($this->first) {
            $this->first = array_slice($this->words, 0, 8);
            $this->words = array_slice($this->words, 8);

            shuffle($this->words);

            $this->words = $this->first + $this->words;

            $this->first = false;
            return;
        }
        shuffle($this->words);
    }

    /**
     * Calculate the number of words in a sentence, the number of sentences in a paragraph
     * and the distribution of commas in a sentence.
     *
     * @access private
     * @param double $mean average value
     * @param double $stdDev standard deviation
     * @return int  calculated distribution
     */
    private function gauss(float $mean, float $stdDev): int
    {
        $gaussianXValue = mt_rand() / mt_getrandmax();
        $gaussianYValue = mt_rand() / mt_getrandmax();
        return intval((sqrt(-2 * log($gaussianXValue)) * cos(2 * pi() * $gaussianYValue)) * $stdDev + $mean);
    }

    /**
     * Punctuate
     *
     * Applies punctuation to a sentence. This includes a period at the end,
     * the injection of commas as well as capitalizing the first letter of the
     * first word of the sentence.
     *
     * @access private
     * @param array<array<string>> $sentences the sentences we would like to punctuate
     * @return void
     */
    private function punctuate(array &$sentences): void
    {
        foreach ($sentences as $key => $sentence) {
            $words = count($sentence);
            // Only worry about commas on sentences longer than 4 words
            if ($words > 4) {
                $mean    = log($words, 6);
                $stdDev = $mean / 6;
                $commas  = $this->gauss($mean, $stdDev);

                for ($i = 1; $i <= $commas; $i++) {
                    $word = round($i * $words / ($commas + 1));

                    if ($word < ($words - 1) && $word > 0) {
                        $sentence[$word] .= ',';
                    }
                }
            }

            $sentences[$key] = ucfirst(implode(' ', $sentence) . '.');
        }
    }
}
