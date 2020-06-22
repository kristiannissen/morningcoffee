<?php

namespace MorningCoffee;

use MorningCoffee\CoffeeException;
use MorningCoffee\ParserInterface;
/**
 * class Coffee
 */
class Coffee
{
    protected $file_path;
    protected $file_contents;
    protected $parser;

    /**
     * @param ParserInterface $parser
     */
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

        if (!file_exists($file_path)) {
            throw new CoffeeException("The file does not exist");
        }

        $this->file_contents = file_get_contents($this->file_path);

        if ($this->file_contents == "") {
            throw new CoffeeException("The file is empty");
        }

        if (count($context) > 0) {
            $this->file_contents = $this->parseContextArray($context);
        }

        $this->file_contents = $this->runParser();

        return $this->file_contents;
    }

    /*
     * @return string
     */
    public function runParser()
    {
        $contents = $this->parser->parse($this->file_contents);

        $tmp_file = tmpfile();
        $tmp_file_meta = (object) stream_get_meta_data($tmp_file);
        fwrite($tmp_file, $contents);
        $tmp_include = include $tmp_file_meta->uri;
        fclose($tmp_file);

        return $tmp_include;
    }

    /*
     * @param array $context
     * @return string
     */
    public function parseContextArray(array $context)
    {
        $key_val = [];
        foreach ($context as $key => $val) {
            $_key = "{" . $key . "}";

            switch (gettype($val)) {
                case 'string':
                    $key_val[$_key] = $val;
                    break;
                case 'object':
                    $key_val[$_key] = call_user_func($val);
                    break;
                default:
                    throw new CoffeeException("Unsupported value");
                    break;
            }
        }
        $markup = str_replace(
            array_keys($key_val),
            array_values($key_val),
            $this->file_contents
        );

        return $markup;
    }
}
