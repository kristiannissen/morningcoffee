<?php
/**
 * BashParser class
 */
namespace MorningCoffee;

use MorningCoffee\ParserInterface;
use MorningCoffee\Str;

class BashParser implements ParserInterface
{
    public function __construct()
    {
        $this->content = "";
    }

    /**
     * @param string $content
     */
    public function parse(string $content)
    {
      $line = strtok($content, PHP_EOL);

      while ($line !== false) {
        if (Str::contains($line, '/([^el]if)\s?\[{1,2}/')) {
          // if [[ 1 + 1 = 2]] then
          $code = str_replace(
            ["[[", "]]", "=", "then"],
            ["(", ")", "==", ":"],
            trim($line)
          );
          $match = Str::matches($line, '/([^el]if)\s?\[{1,2}/');
          $content = substr_replace(
            $content,
            $code,
            stripos($content, $match),
            strlen(trim($line))
          );
        }
        $line = strtok(PHP_EOL);
      }

      return $content;
    }
}
