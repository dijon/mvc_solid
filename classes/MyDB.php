<?php


namespace classes;

use \SQLite3;

class MyDB extends SQLite3
{
    public function __construct() {
        parent::__construct('../books.db');
    }
}