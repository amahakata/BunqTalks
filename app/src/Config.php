<?php

class Config {
    private $dbSettings;
    private $errorSettings;

    public function __construct(){
        $this->dbSettings = [
            'driver' => 'pdo_sqlite',
            'path' => APP_ROOT . '\database\bunqtalk.db',
            'driverOptions' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
        ];
        $this->errorSettings = [
            'displayErrorDetails' =>true,
            'logErrors'=> true,
            'logErrorDetails' => true
        ];
    }

    public function getDbConfig(){
        return $this->dbSettings;
    }

    public function getErrorSettings(){
        return $this->errorSettings;
    }
}