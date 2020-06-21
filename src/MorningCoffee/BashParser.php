<?php

namespace MorningCoffee;

use MorningCoffee\ParserInterface;

class BashParser implements ParserInterface
{
    private $content;
    
    public function __construct()
    {
        $this->content = "";
    }

    public function parse(string $content)
    {
        $this->content = $content;
    }
}
