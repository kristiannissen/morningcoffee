<?php

namespace MorningCoffee;

use MorningCoffee\CoffeeException;
use MorningCoffee\ParserInterface;
/**
 * class Coffee
 */
class Coffee {
    protected $file_path;
    protected $file_content;
    protected $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->file_path = "";
        $this->file_content = "";
        $this->parser = $parser;
    }
    /*
     * @param string $file_path
     * @param array $context
     * @return string
     */
    public function render(string $file_path, array $context = [])
    {
        $this->file_path = $file_path;

        if (!file_exists($file_path))
            throw new CoffeeException("The file does not exist");

        $this->file_content = file_get_contents($this->file_path);

        if ($this->file_content == "")
            throw new CoffeeException("The file is empty");

        if (count($context) > 0)
        {
           $this->file_content = $this->parseContextArray($context); 
        }

        // $this->file_content = $this->parser->parse($this->file_content);
        $this->file_content = $this->runParser();

        return $this->file_content;
    }

    /*
     * @return string
     */
    public function runParser()
    {
        ob_start();
        eval("?>". $this->parser->parse($this->file_content) ."<?");
        $tmp_string = ob_get_contents();
        ob_end_flush();
        return $tmp_string;
    }

    /*
     * @param array $context
     * @return string
     */
    public function parseContextArray(array $context)
    {
        $key_val = [];
        foreach ($context as $key => $val)
        {
            $_key = "{". $key ."}";

            switch (gettype($val))
            {
                case 'string':
                    $key_val[$_key] = $val;
                    break;
                case 'object':
                    $key_val[$_key] = call_user_func($val);
                    break;
            }
        }
        $markup = str_replace(
            array_keys($key_val),
            array_values($key_val),
            $this->file_content
        );

        return $markup;
    }
}
