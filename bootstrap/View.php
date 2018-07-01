<?php
declare(strict_types=1);

namespace App\Bootstrap;

class View
{
    public function __construct() {}

    public static function load($id) {
      $path = "../app/Views/{$id}.php";
      $html = file_get_contents($path);
      return $html;
    }
    
}