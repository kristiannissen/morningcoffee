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

        var_dump($this->code);

        return $this->content;
    }
}
