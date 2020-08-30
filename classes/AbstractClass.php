<?php

namespace classes;

abstract class AbstractClass
{
    protected function json($json, $httpStatus = 200) {
        header_remove();

        header("Content-type: application/json; charset=utf-8");
        http_response_code($httpStatus);

        echo json_encode($json);

        exit();
    }
}