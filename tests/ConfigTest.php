<?php

use Sphinx\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testInstanceNoArguments()
    {
        $config = new Config();

        $this->assertInstanceOf('Sphinx\Config', $config);
    }

    public function testInstanceWithArguments()
    {
        $config = new Config([
            'host' => 0,
            'port' => 9306,
        ]);

        $this->assertInstanceOf('Sphinx\Config', $config);
        $this->assertEquals($config->getHost(), 0);
        $this->assertEquals($config->getPort(), 9306);
    }

    public function testSet()
    {
        $config = new Config([
            'host' => 0,
            'port' => 9306,
        ]);

        $this->assertInstanceOf('Sphinx\Config', $config);
        $this->assertEquals($config->getHost(), 0);
        $this->assertEquals($config->getPort(), 9306);

        $config->set([
            'host' => 1,
            'port' => 9307,
        ]);

        $this->assertEquals($config->getHost(), 1);
        $this->assertEquals($config->getPort(), 9307);

        $config->setHost('localhost');
        $config->setPort(3306);

        $this->assertEquals($config->getHost(), 'localhost');
        $this->assertEquals($config->getPort(), 3306);
    }

    public function testGet()
    {
        $opts = [
            'host' => 0,
            'port' => 9306,
        ];

        $config = new Config($opts);

        $this->assertInstanceOf('Sphinx\Config', $config);
        $this->assertEquals($config->get(), $opts);
        $this->assertEquals($config->getHost(), 0);
        $this->assertEquals($config->getPort(), 9306);
    }
}
