<?php

require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ResponseService.php");

class BaseController {
    protected $mysqli;

    public function __construct() {
        global $mysqli;
        $this->mysqli = $mysqli;
    }

    protected function handleException(Exception $e) {
        echo ResponseService::error_response("An error occurred: " . $e->getMessage(), 500);
    }
}