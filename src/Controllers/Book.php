<?php

namespace src\Controllers;

use classes\AbstractClass;

class Book extends AbstractClass
{
    public function show()
    {
       return $this->json(['data'=>'some']);
    }

    public function create()
    {
        // ...
    }

    public function update()
    {
        // ...
    }

    public function delete()
    {
        // ...
    }
}