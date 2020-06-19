<?php

namespace MorningCoffee;

class Coffee {
    protected $file_path;
    protected $file_content;

    public function __construct()
    {
        $this->file_path = "";
        $this->file_content = "";
    }
    /*
     * @param $file_path string
     * @param context array
     * @return string
     */
    public function render(string $file_path, array $context)
    {
        $this->file_path = $file_path;

        if (!file_exists($file_path))
            return user_error();

        $this->file_content = file_get_contents($this->file_path);

        if (count($context) > 0)
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
}
