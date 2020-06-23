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
        if (Str::contains($line, '/([^el]if)\s?\[{2}/')) {
          // if [[ 1 + 1 = 2]] then
          $code = str_replace(
            ["[[", "]]", "=", " then"],
            ["(", ")", "==", ":"],
            trim($line)
          );
          $match = Str::matches($line, '/([^el]if)\s?\[{2}/');
          $content = substr_replace(
            $content,
            "<?php ". $code ." ?>",
            stripos($content, $match),
            strlen(trim($line))
          );
        }

        if (Str::contains($line, "/(elif)\s?\[{2}/")) {
          // elif [[ 1 + 1 = 3]] then
          $code = str_replace(
            ["elif", "[[", "]]", " then"],
            ["elseif", "(", ")", ":"],
            trim($line)
          );
          $match = Str::matches($line, '/(elif)\s?\[{2}(.*)\]{2}\s?(then)/');
          $content = substr_replace(
            $content,
            "<?php ". $code ." ?>",
            stripos($content, $match),
            strlen(trim($line))
          );
        }

        if (Str::contains($line, '/(fi)/')) {
          // fi
          $match = Str::matches($line, '/(fi)/');
          $content = substr_replace(
            $content,
            "<? endif ?>",
            stripos($content, $match),
            strlen(trim($line))
          );
        }

        if (Str::contains($line, '/(echo)/')) {
          // echo "1 + 1 is 2"
          $match = Str::matches($line, '/(echo)\s=?(.*)/');
          $content = substr_replace(
            $content,
            "<?php ". trim($match) ." ?>",
            stripos($content, $match),
            strlen(trim($line))
          );
        }

        if (Str::contains($line, '/([A-Z]{1}\w+)=(.*)$/')) {
          // Variables
          $match = Str::matches($line, '/([A-Z]{1}\w+)=(.*)$/');
          preg_match('/\((.*)\)/', trim($match), $vars);
          $vars_arr = str_replace(
            $vars[1],
            join(',', explode(' ', $vars[1])),
            $match
          );
          $content = substr_replace(
            $content,
            "<?php $". trim($vars_arr) ." ?>",
            stripos($content, $match),
            strlen(trim($line))
          );
        }

        $line = strtok(PHP_EOL);
      }

      return $content;
    }

    public static function parseIf($content) {
      
    }
}
