<?php
namespace Sphinx;

class Results
{
    protected $results;
    protected $metadata;

    public function __construct(array $results, array $metadata)
    {
        $this->results = $results;
        $this->processMeta($metadata);
    }

    public function getResults()
    {
        return $this->results;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function getTotal()
    {
        return isset($this->metadata['total']) ? $this->metadata['total'] : 0;
    }

    public function getTime()
    {
        return isset($this->metadata['time']) ? $this->metadata['time'] : 0;
    }

    public function getKeywords()
    {
        return isset($this->metadata['keywords']) ? $this->metadata['keywords'] : [];
    }

    private function processMeta($metadata)
    {
        foreach ($metadata as $meta) {
            if (strpos($meta['Variable_name'], 'keyword') !== false) {
                if (!isset($this->metadata['keywords'])) {
                    $this->metadata['keywords'] = [];
                }

                $this->metadata['keywords'][] = $meta['Value'];

            } else if (strpos($meta['Variable_name'], 'docs') !== false) {
                if (!isset($this->metadata['docs'])) {
                    $this->metadata['docs'] = [];
                }

                $this->metadata['docs'][] = $meta['Value'];

            } else if (strpos($meta['Variable_name'], 'hits') !== false) {
                if (!isset($this->metadata['hits'])) {
                    $this->metadata['hits'] = [];
                }

                $this->metadata['hits'][] = $meta['Value'];

            } else {
                $this->metadata[$meta['Variable_name']] = $meta['Value'];
            }
        }
    }
}
