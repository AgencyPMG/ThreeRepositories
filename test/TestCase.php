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
    protected $repo;

    public function testArticlesCanBePersistedUpdatedFetchedAndRemoved()
    {
        $this->assertEmpty($this->repo->findAll());
        $this->assertEmpty($this->repo->findByYear(2015));

        $article = $this->createArticle();
        $article->setTitle('Hello');
        $article->setBody('World');
        $article->setYear(2015);

        $id = $this->repo->add($article);

        $this->assertCount(1, $this->repo->findAll());
        $this->assertEmpty($this->repo->findByYear(2014));
        $this->assertCount(1, $this->repo->findByYear(2015));

        $article = $this->repo->find($id);
        $this->assertInstanceOf(Article::class, $article);

        $article->setTitle('changed');
        $this->repo->add($article);

        $article = $this->repo->find($id);
        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('changed', $article->getTitle());

        $this->repo->remove($article);
        $this->assertNull($this->repo->find($id));
    }

    abstract protected function createArticle();
}
