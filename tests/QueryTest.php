<?php

use Sphinx\Config;
use Sphinx\Query;

class QueryTest extends PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = new Config(['host' => 0, 'port' => 9306]);
    }

    public function testInstance()
    {
        $query = new Query($this->config);

        $this->assertInstanceOf('Sphinx\Query', $query);
    }

    public function testGet()
    {
        $query = new Query($this->config);

        $this->assertEquals($query->get(),
            [
                'fields'    => [],
                'indexes'   => [],
                'where'     => [],
                'groupBy'   => [],
                'orderBy'   => [],
                'limit'     => 20,
                'offset'    => 0,
            ]
        );
    }

    public function testSet()
    {
        $query = new Query($this->config);
        $props = [
            'fields' => ['id', 'title'],
            'indexes' => ['test1'],
            'where' => ['title' => 'test'],
            'groupBy' => [],
            'orderBy' => ['id' => 'DESC'],
            'offset' => 0,
            'limit' => 10,
        ];

        $query->set($props);

        $this->assertEquals($query->get(), $props);
    }

    public function testExecute()
    {
        $query = new Query($this->config);
        $query->set([
            'fields' => ['*'],
            'indexes' => ['test1'],
            'where' => [
                'title:Match' => 'test',
            ],
            'groupBy' => ['group_id'],
            'orderBy' => ['id' => 'DESC'],
        ]);

        $results = $query->execute();

        $this->assertInstanceOf('Sphinx\Results', $results);
    }
}
