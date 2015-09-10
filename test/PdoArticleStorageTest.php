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
    private $conn, $store;

    public function testArticlesCanBePersistedUpdatedFetchedAndRemoved()
    {
        $this->assertEmpty($this->store->findAll());
        $this->assertEmpty($this->store->findByYear(2015));

        $article = new SimpleArticle();
        $article->setTitle('Hello');
        $article->setBody('World');
        $article->setYear(2015);

        $id = $this->store->persist($article);

        $this->assertCount(1, $this->store->findAll());
        $this->assertEmpty($this->store->findByYear(2014));
        $this->assertCount(1, $year = $this->store->findByYear(2015));

        $article = $this->store->find($id);
        $this->assertInstanceOf(Article::class, $article);

        $article->setTitle('changed');
        $this->store->persist($article);

        $article = $this->store->find($id);
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('changed', $article->getTitle());

        $this->store->remove($article);
        $this->assertNull($this->store->find($id));
    }

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
}
