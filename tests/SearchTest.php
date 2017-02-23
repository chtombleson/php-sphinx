<?php

use Sphinx\Config;
use Sphinx\Query;
use Sphinx\Search;

class SearchTest extends PHPUnit_Framework_TestCase
{
    protected $config;
    protected $query;

    public function setUp()
    {
        $this->config = new Config(['host' => 0, 'port' => 9306]);
        $this->query = new Query($this->config);

        $this->query->set([
            'fields' => ['*'],
            'indexes' => ['test1'],
            'where' => ['title:Match' => 'test'],
            'groupBy' => ['group_id'],
            'orderBy' => ['id' => 'DESC'],
            'offset' => 0,
            'limit' => 10,
        ]);
    }

    public function testInstance()
    {
        $search = new Search();

        $this->assertInstanceOf('Sphinx\Search', $search);
        $this->assertInstanceOf('Sphinx\Search', Search::getInstance());
    }

    public function testExecute()
    {
        $search = new Search();
        $results = $search->execute($this->query);

        $this->assertInstanceOf('Sphinx\Results', $results);
    }
}
