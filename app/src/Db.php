<?php
use Doctrine\DBAL\DriverManager as DriverManager;

class Db {

    private $qb;
    private $conn;
    private $connectionParam;
    public function __construct(Config $config){
        $this->connectionParams = $config->getDbConfig();
        $this->conn = DriverManager::getConnection($this->connectionParams);
        $this->qb = $this->conn->createQueryBuilder();
    }

    public function getQueryBuilder(){
        return $this->qb;
    }

}