<?php
namespace Sphinx;

class Search
{
    private static $instance;
    protected $lastQuery;

    public function execute(Query $query)
    {
        $this->lastQuery = $query;

        return $query->execute();
    }

    public function getLastQuery()
    {
        return $this->lastQuery();
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
