<?php

use Sphinx\Config;
use Sphinx\Connection;

class ConnectionTest extends PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = new Config(['host' => 0, 'port' => 9306]);
    }

    public function testInstance()
    {
        $connection = new Connection($this->config);
        $this->assertInstanceOf('Sphinx\Connection', $connection);

        $connection = new Connection($this->config, false);
        $this->assertInstanceOf('Sphinx\Connection', $connection);
    }

    public function testSuccessfulConnect()
    {
        $connection = new Connection($this->config, false);
        $connection->connect();

        $this->assertTrue($connection->isConnected());
    }

    public function testFailedConnect()
    {
        $connection = new Connection($this->config, false);
        $connection->getConfig()->setHost('localhost')->setPort('12000');

        try {
            $connection->connect();
        } catch (Exception $e) {}

        $this->assertFalse($connection->isConnected());
    }

    public function testGetPDO()
    {
        $connection = new Connection($this->config);

        $this->assertInstanceOf('PDO', $connection->getPDO());
    }

    public function testGetConfig()
    {
        $connection = new Connection($this->config, false);

        $this->assertInstanceOf('Sphinx\Config', $connection->getConfig());
        $this->assertEquals($connection->getConfig(), $this->config);
    }

    public function testSetConfig()
    {
        $connection = new Connection($this->config, false);
        $config = new Config(['host' => 'localhost', 'port' => 3306]);

        $connection->setConfig($config);

        $this->assertInstanceOf('Sphinx\Config', $connection->getConfig());
        $this->assertEquals($connection->getConfig(), $config);
    }
}
