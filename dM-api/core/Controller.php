<?php

class Controller
{
    protected function getRequestBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    protected function respond($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
?>