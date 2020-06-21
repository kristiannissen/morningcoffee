<?php

namespace MorningCoffee;

use MorningCoffee\CoffeeException;
/**
 * class Coffee
 */
class Coffee {
    protected $file_path;
    protected $file_content;

    public function __construct()
    {
        $this->file_path = "";
        $this->file_content = "";
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

        return $this->file_content;
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
