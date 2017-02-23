<?php
namespace Sphinx;

class Query
{
    protected $config;
    protected $builder;
    protected $connection;
    protected $properties = [
        'fields'    => [],
        'indexes'   => [],
        'where'     => [],
        'groupBy'   => [],
        'orderBy'   => [],
        'limit'     => 20,
        'offset'    => 0,
    ];

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->builder = new SQLBuilder($this);
        $this->connection = new Connection($config);
    }

    public function get()
    {
        return $this->properties;
    }

    public function set(array $properties)
    {
        if (isset($properties['fields'])) {
            $this->setFields($properties['fields']);
        }

        if (isset($properties['indexes'])) {
            $this->setIndexes($properties['indexes']);
        }

        if (isset($properties['where'])) {
            $this->setWhere($properties['where']);
        }

        if (isset($properties['groupBy'])) {
            $this->setGroupBy($properties['groupBy']);
        }

        if (isset($properties['orderBy'])) {
            $this->setOrderBy($properties['orderBy']);
        }

        if (isset($properties['offset'])) {
            $this->setOffset($properties['offset']);
        }

        if (isset($properties['limit'])) {
            $this->setLimit($properties['limit']);
        }

        return $this;
    }

    public function getFields()
    {
        return $this->properties['fields'];
    }

    public function setFields(array $fields)
    {
        $this->properties['fields'] = $fields;

        return $this;
    }

    public function getIndexes()
    {
        return $this->properties['indexes'];
    }

    public function setIndexes(array $indexes)
    {
        $this->properties['indexes'] = $indexes;

        return $this;
    }

    public function getWhere()
    {
        return $this->properties['where'];
    }

    public function setWhere(array $where)
    {
        $this->properties['where'] = $where;

        return $this;
    }

    public function getGroupBy()
    {
        return $this->properties['groupBy'];
    }

    public function setGroupBy(array $groupBy)
    {
        $this->properties['groupBy'] = $groupBy;

        return $this;
    }

    public function getOrderBy()
    {
        return $this->properties['orderBy'];
    }

    public function setOrderBy(array $orderBy)
    {
        $this->properties['orderBy'] = $orderBy;

        return $this;
    }

    public function getOffset()
    {
        return $this->properties['offset'];
    }

    public function setOffset($offset)
    {
        $this->properties['offset'] = $offset;

        return $this;
    }

    public function getLimit()
    {
        return $this->properties['limit'];
    }

    public function setLimit($limit)
    {
        $this->properties['limit'] = $limit;

        return $this;
    }

    public function getSQL()
    {
        return $this->builder->buildSQL();
    }

    public function execute()
    {
        $sql = $this->getSQL();

        $results = $this->connection->executeQuery($sql['query'], $sql['parameters']);
        $metadata = $this->connection->executeQuery('SHOW META');

        if (!$results || !$metadata) {
            return false;
        }

        return new Results($results, $metadata);
    }
}
