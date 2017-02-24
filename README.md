# Sphinx

A PHP library to interface to a sphinx search server using SphinxSQL.

## Installation

To use this library you will need to have a sphinx server setup. You can find instructions
on how to do so here: [http://sphinxsearch.com/docs/current.html#installation](http://sphinxsearch.com/docs/current.html#installation)

Installing this library is as simple as running the following:

    $ composer install chtombleson/sphinx

## Usage

Basic search:

    <?php

    use Sphinx\Config;
    use Sphinx\Query;

    // Config that contains details to connect to the sphinx server
    $config = new Config(['host' => 0, 'port' => 9306]);

    // Build a query
    $query = new Query($config);

    $query->setFields(['*'])    // Set field to select
        ->setIndexes(['test1']) // Set indexes to search
        ->setWhere(['title:Match' => 'test']) // Set where (match title where like test

    $results = $query->execute(); // Run the query in sphinx server

    var_dump($results->getResults());
    var_dump($results->getMetadata());

## License
Copyright 2017 Christopher Tombleson

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in the
Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
and to permit persons to whom the Software is furnished to do so, subject to the
following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
USE OR OTHER DEALINGS IN THE SOFTWARE.
