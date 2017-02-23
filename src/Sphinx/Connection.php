<?php
namespace Sphinx;

use \PDO;
use \PDOException;

class Connection
{
    protected $config;
    protected $pdo;
    protected $lastPdoStatement;
    protected $isConnected = false;

    public function __construct(Config $config, $connect = true)
    {
        $this->config = $config;

        if ($connect) {
            $this->connect();
        }
    }

    public function connect()
    {
        $dsn = 'mysql:host=' . $this->config->getHost() . ';port=' . $this->config->getPort();

        try {
            $this->pdo = new PDO($dsn);
            $this->isConnected = true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $this;
    }

    public function isConnected()
    {
        return $this->isConnected;
    }

    public function executeQuery($sql, array $parameters = [])
    {
        $this->lastPdoStatement = $this->pdo->prepare($sql);

        if (!$this->lastPdoStatement->execute($parameters)) {
            $errorInfo = $this->lastPdoStatement->errorInfo();
            $errorMsg = 'SQLSTATE[' . $errorInfo[0] . '] DRIVER[' . $errorInfo[1] . '] ' . $errorInfo[2];

            throw new Exception('Sphinx Connection query failed, PDO Error: ' . $errorMsg);
        }

        return $this->lastPdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastPDOStatement()
    {
        return $this->lastPdoStatement;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }
}
