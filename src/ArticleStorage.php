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
 * The read/write side of the article storage backends.
 *
 * @since   0.1
 */
interface ArticleStorage extends ArticleRepository
{
    /**
     * Persist the article in the storage backend.
     *
     * @param   $article The article to persist. If an ID is present the article
     *          will be updated.
     */
    public function persist(Article $article);

    /**
     * Remove an article from the storage backend.
     *
     * @param   Article|int $article The article to remove
     * @return  void
     */
    public function remove($article);
}
