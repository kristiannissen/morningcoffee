<?php
/**
 * BashParser class
 */
namespace MorningCoffee;

use MorningCoffee\ParserInterface;

class BashParser implements ParserInterface
{
    // @property string $content
    private $content;
    // @property array $patters
    public static $patterns = [
        '/([^el]if)\s?\[\[\s?(.*)\s?\]\]\s?(then)/m',
        '/(elif)\s?\[\[\s?(.*)\s?\]\]\s?(then)/m',
        '/(echo)\s("?.*"?)/m',
        '/(fi)/m',
        '/\s=\s/m',
        '/([A-Z]{1}\w+)\=\((.*)\)/m',
        '/(for)\s(.*)\sas\s(.*)\s(do)/m',
        '/(done)/m',
    ];
    // @property array $replacements
    public static $replacements = [
        '<?php ${1} (${2}): ?>', // if
        '<?php elseif (${2}): ?>', // elif
        '<?php ${1} ${2}; ?>', // echo
        '<?php endif ?>', // fi
        '==', // =
        '<?php $${1}=[${2}] ?>', // Variables
        '<?php foreach ($${2} as $${3}): ?>', // for loop
        '<?php endforeach ?>', // done
    ];

    public function __construct()
    {
        $this->content = "";
    }

    /**
     * @param string $content
     */
    public function parse(string $content)
    {
        /**
         * Replace regex patterns with proper PHP code
         */
        $this->content = preg_replace(
            self::$patterns,
            self::$replacements,
            $content
        );

        preg_match_all('/\[(.*)\]\s?$/m', $this->content, $matches);
        if (count($matches)) {
            for ($i = 0; $i < count($matches); $i++) {
                for ($j = 0; $j < count($matches[$i]); $j++) {
                    $this->content = str_replace(
                        $matches[$i][$j],
                        join(",", explode(" ", $matches[$i][$j])),
                        $this->content
                    );
                }
            }
        }

        return $this->content;
    }
}
