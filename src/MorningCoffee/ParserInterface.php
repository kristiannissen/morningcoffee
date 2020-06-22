<?php
/**
 * @ParserInterface
 */
namespace MorningCoffee;

interface ParserInterface
{
    /**
     * @param string $content
     * @return PHP output
     */
    public function parse(string $content);
}
