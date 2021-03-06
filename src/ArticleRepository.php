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

/**
 * This is the "read" side of our repository, provides methods for fetching
 * articles from the database.
 *
 * @since   0.1
 */
interface ArticleRepository
{
    /**
     * Find a single article by its identifier.
     *
     * @param   int $id
     * @return  Article|null Null if no article is found
     */
    public function find($id);

    /**
     * Find every article ever, ordered by date.
     *
     * @return  Article[]
     */
    public function findAll();

    /**
     * Find all the articles from a given year.
     *
     * @param   int $year The year to look up
     * @return  Article[]
     */
    public function findByYear($year);

    /**
     * Add the article to the repository.
     *
     * @param   $article The article to persist. If an ID is present the article
     *          will be updated.
     * @return  int The article's primary key.
     */
    public function add(Article $article);

    /**
     * Remove an article from the storage backend.
     *
     * @param   Article|int $article The article to remove
     * @return  void
     */
    public function remove($article);
}
