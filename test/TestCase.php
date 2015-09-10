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

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $store;

    public function testArticlesCanBePersistedUpdatedFetchedAndRemoved()
    {
        $this->assertEmpty($this->store->findAll());
        $this->assertEmpty($this->store->findByYear(2015));

        $article = $this->createArticle();
        $article->setTitle('Hello');
        $article->setBody('World');
        $article->setYear(2015);

        $id = $this->store->add($article);

        $this->assertCount(1, $this->store->findAll());
        $this->assertEmpty($this->store->findByYear(2014));
        $this->assertCount(1, $this->store->findByYear(2015));

        $article = $this->store->find($id);
        $this->assertInstanceOf(Article::class, $article);

        $article->setTitle('changed');
        $this->store->add($article);

        $article = $this->store->find($id);
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('changed', $article->getTitle());

        $this->store->remove($article);
        $this->assertNull($this->store->find($id));
    }

    abstract protected function createArticle();
}
