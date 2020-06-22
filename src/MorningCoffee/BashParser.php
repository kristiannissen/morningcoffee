<?php

namespace MorningCoffee;

use MorningCoffee\ParserInterface;

class BashParser implements ParserInterface
{
    private $content;
    public static $patterns = [
        '/([^el]if)\s\[\[(.*)\]\]\s(then)$/m',
        '/(elif)\s\[\[(.*)\]\]\s(then)$/m',
        '/(echo)\s("?.*"?)/m',
        '/(fi)$/m',
        '/\s=\s/m',
        '/([A-Z]{1}\w+)\=\((.*)\)/m',
        '/(for)\s(.*)\sas\s(.*)\s(do)/m',
        '/(done)/m',
    ];
    public static $replacements = [
        '<?php ${1} (${2}): ?>', // if
        '<?php elseif (${2}): ?>', // elif
        '<?php ${1} ${2}; ?>', // echo
        'endif ?>', // fi
        '==', // =
        '$${1}=[${2}];', // Variables
        'foreach ($${2} as $${3}) {', // for loop
        '}', // done
    ];

    public function __construct()
    {
        $this->content = "";
    }

    public function parse(string $content)
    {
        $this->content = preg_replace(
            self::$patterns,
            self::$replacements,
            $content
        );

        return $this->content;
    }
}
