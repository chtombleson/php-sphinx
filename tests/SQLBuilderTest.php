<?php

use Sphinx\Config;
use Sphinx\Query;
use Sphinx\SQLBuilder;

class SQLBuilderTest extends PHPUnit_Framework_TestCase
{
    protected $config;
    protected $query;

    public function setup()
    {
        $this->config = new Config(['host' => 0, 'port' => 9306]);
        $this->query = new Query($this->config);

        $this->query->set([
            'fields' => ['id', 'title'],
            'indexes' => ['test1'],
            'where' => ['title' => 'test'],
            'groupBy' => ['id'],
            'orderBy' => ['id' => 'DESC'],
            'offset' => 0,
            'limit' => 10,
        ]);
    }

    public function testBuildSQL()
    {
        $builder = new SQLBuilder($this->query);
        $sqlQuery = $builder->buildSQL();

        $this->assertEquals($sqlQuery['query'], 'SELECT id,title FROM test1 WHERE title=? GROUP BY id ORDER BY id DESC LIMIT 0,10');
        $this->assertEquals($sqlQuery['parameters'], ['test']);
    }
}
