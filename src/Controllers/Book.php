<?php

namespace src\Controllers;

use classes\AbstractClass;
use classes\MyDB;

class Book extends AbstractClass
{
    public function show()
    {
       return $this->json(['data'=>'some']);
    }

    public function create()
    {
        try
        {
            $db = new MyDB();
            if(!$db){
                echo $db->lastErrorMsg();
            } else {
                echo "Opened database successfully\n";
            }
        }
        catch(\Exception $e)
        {
            print 'Exception : '.$e->getMessage();
        }
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