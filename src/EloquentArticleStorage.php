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
 * An article storage implementation backed by Laravel's Eloquent.
 *
 * @since   0.1
 */
final class EloquentArticleStorage implements ArticleRepository
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return EloquentArticle::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return EloquentArticle::query()
            ->orderBy('year', 'DESC')
            ->orderBy('title', 'ASC')
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return EloquentArticle::where('publishyear', $year)
            ->orderBy('publishyear', 'DESC')
            ->orderBy('title', 'ASC')
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function add(Article $article)
    {
        if (!$article instanceof EloquentArticle) {
            throw new \InvalidArgumentException(sprintf(
                '%s expects and instance of %s, got "%s"',
                __METHOD__,
                EloquentArticle::class,
                get_class($article)
            ));
        }

        $article->save();

        return $article->id;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($article)
    {
        $del = $this->find($article instanceof Article ? $article->getIdentifier() : $article);
        $del->delete();
    }
}
