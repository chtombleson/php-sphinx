<?php
namespace Sphinx;

class Config
{
    protected $properties = [];

    public function __construct(array $properties = [])
    {
        $this->set($properties);
    }

    public function get()
    {
        return $this->properties;
    }

    public function set(array $properties)
    {
        if (isset($properties['host'])) {
            $this->setHost($properties['host']);
        }

        if (isset($properties['port'])) {
            $this->setPort($properties['port']);
        }

        return $this;
    }

    public function getHost()
    {
        return $this->properties['host'];
    }

    public function setHost($host)
    {
        $this->properties['host'] = $host;

        return $this;
    }

    public function getPort()
    {
        return $this->properties['port'];
    }

    public function setPort($port)
    {
        $this->properties['port'] = $port;

        return $this;
    }
}
