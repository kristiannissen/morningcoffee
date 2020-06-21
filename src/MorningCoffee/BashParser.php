<?php

namespace MorningCoffee;

use MorningCoffee\ParserInterface;

class BashParser implements ParserInterface
{
    private $content;
    private $code;
    public static $patterns = [
        '/([^el]if)\s\[\[(.*)\]\]\s(then)$/mx',
        '/(elif)\s\[\[(.*)\]\]\s(then)$/mx',
        '/(echo)\s("?.*"?)/mx',
        '/(fi)$/mx',
        '/\s=\s/m',
        '/([A-Z]{1}\w+)\=\((.*)\)/',
        '/(for)\s(.*)\sas\s(.*)\s(do)/m',
        '/(done)/m',
    ];
    public static $replacements = [
        '${1} (${2}) {', // if
        '} elseif (${2}) {', // elif
        '${1} ${2};', // echo
        '}', // fi
        '==', // =
        '$${1}=[${2}];', // Variables
        'foreach ($${2} as $${3}) {', // for loop
        '}', // done
    ];
    
    public function __construct()
    {
        $this->content = "";
        $this->code = "";
    }

    public function parse(string $content)
    {
        $this->content = $content;

        $this->content = preg_replace(
            self::$patterns,
            self::$replacements,
            $this->content
        );

        return $this->content;
    }
}
