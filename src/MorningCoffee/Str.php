<?php

namespace MorningCoffee;

class Str {
  /**
   * @param string $string
   * @param string $chars
   * */
  public static function starts_with($str, $chars) : string {
    return (substr($str, 0, strlen($str)) === $chars);
  }

  public static function ends_with($str, $chars) : string {
    $len = strlen($str);
    if ($len == 0) {
      return true;
    }
    return (substr($str, - $len) === $chars);
  }

  public static function contains($str, $reg) : bool {
    preg_match($reg, $str, $m);
    return count($m);
  }

  public static function matches($str, $reg) : string {
    preg_match($reg, $str, $m);
    return trim($m[0]);
  }

  public static function is($a, $b) : bool {
    return trim($a) === trim($b);
  }
}
