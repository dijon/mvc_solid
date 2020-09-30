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
                $db->exec("CREATE TABLE books(id INTEGER PRIMARY KEY, name TEXT)");
                $stmt = $db->prepare("INSERT INTO books(name) VALUES (:book)");
                $stmt->bindValue(':book', 'proba', SQLITE3_TEXT);
                $stmt->execute();
                echo "Row inserted successfully\n";
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