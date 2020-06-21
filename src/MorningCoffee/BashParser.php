<?php

namespace MorningCoffee;

use MorningCoffee\ParserInterface;

class BashParser implements ParserInterface
{
    private $content;
    private $code;
    
    public function __construct()
    {
        $this->content = "";
        $this->code = "";
    }

    public function parse(string $content)
    {
        $this->content = $content;
        $patterns = [
            '/([^el]if)\s\[\[(.*)\]\]\s(then)$/mx',
            '/(elif)\s\[\[(.*)\]\]\s(then)$/mx',
            '/(echo)\s("?.*"?)/mx',
            '/(fi)$/mx',
        ];
        $replacements = [
            '[${1} (${2}) {', // if
            '${1} (${2}) {', // elif
            '${1} ${2};', // echo
            '} ]', // fi
        ];

        $this->code = preg_replace(
            $patterns,
            $replacements,
            $this->content
        );

        var_dump($this->code);

        return $this->content;
    }
}
