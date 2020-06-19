<?php

namespace MorningCoffee;
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
        $markup = "";

        if (!file_exists($file_path))
            //TODO: Should throw an exception instead
            return trigger_error(
                "The file $file_path does not exist",
                E_USER_ERROR
            );

        $this->file_content = file_get_contents($this->file_path);

        if ($this->file_content == "")
            // TODO: Should throw an exception instead
            return trigger_error(
                "The file has no content",
                E_USER_ERROR
            );

        if (count($context) > 0)
        {
           $this->file_content = $this->parseContextArray($context); 
        }

        return $this->file_content;
    }

    public function parseContextArray(array $context)
    {
        $key_val = [];
        foreach ($context as $key => $val)
        {
            $key_val["{".$key."}"] = $val;
        }
        $markup = str_replace(
            array_keys($key_val),
            array_values($key_val),
            $this->file_content
        );

        return $markup;
    }
}
