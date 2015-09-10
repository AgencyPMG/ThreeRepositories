<?php
/*
 * This file is part of pmg/three-repositories
 *
 * Copyright (c) PMG <https://www.pmg.com>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 *
 * @license     http://opensource.org/licenses/MIT MIT
 */

namespace PMG\ThreeRepositories;

class PdoArticleStorageTest extends TestCase
{
    private $conn;

    protected function setUp()
    {
        $this->conn = new \PDO('sqlite::memory:');
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->store = new PdoArticleStorage($this->conn);

        $this->conn->exec(
            'CREATE TABLE articles (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                title TEXT NOT NULL,
                body TEXT NOT NULL,
                publish_year INTEGER NOT NULL
            )'
        );
    }

    protected function createArticle()
    {
        return new SimpleArticle();
    }
}
