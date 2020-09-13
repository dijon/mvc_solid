<?php


namespace classes;

use \SQLite3;

class MyDB extends SQLite3
{
    public function __construct() {
        $this->open('book.db');
    }
}