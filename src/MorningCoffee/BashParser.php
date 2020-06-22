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

    public function parse(string $content)
    {
        $this->content = preg_replace(
            self::$patterns,
            self::$replacements,
            $content
        );

        // split Fruits=['Apple' 'Banana' 'Orange'] into commas sep string
        preg_match_all('/\[(.*)\]/m', $this->content, $matches);
        if (count($matches))
        {
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
