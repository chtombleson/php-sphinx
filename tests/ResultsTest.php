<?php

use Sphinx\Results;

class ResultsTest extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $results = new Results([], []);

        $this->assertInstanceOf('Sphinx\Results', $results);
    }

    public function testGet()
    {
        $foundResults = [
            ['id' => 1, 'name' => 'wicked'],
            ['id' => 2, 'name' => 'stuff'],
        ];

        $metadata = [
            ['Variable_name' => 'total', 'Value' => 2],
            ['Variable_name' => 'keyword[1]', 'Value' => 'test'],
            ['Variable_name' => 'time', 'Value' => 0.0005],
        ];

        $results = new Results($foundResults, $metadata);

        $this->assertEquals($results->getResults(), $foundResults);
        $this->assertEquals($results->getMetadata(), ['total' => 2, 'keywords' => ['test'], 'time' => 0.0005]);
    }
}
