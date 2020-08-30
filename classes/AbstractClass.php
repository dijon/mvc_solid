<?php


namespace classes;


abstract class AbstractClass
{
    protected function json($json) {
        ob_start();//
        header('Content-Type: application/json');
        echo json_encode($json);
        return ob_get_clean();//
    }
}