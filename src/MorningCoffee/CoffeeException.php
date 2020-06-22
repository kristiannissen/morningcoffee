<?php
/**
 * class CoffeeException
 */
namespace MorningCoffee;

class CoffeeException extends \Exception
{
    protected $details;

    public function __construct($details)
    {
        $this->details = $details;
        parent::__construct();
    }

    public function __toString()
    {
        return "No more coffee!!!" . $this->details;
    }
}
