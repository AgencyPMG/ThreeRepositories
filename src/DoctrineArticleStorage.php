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

use Doctrine\ORM\EntityRepository;

/**
 * An `ArticleStorage` implementation backed by Doctrine's ORM.
 *
 * Entity repository provides `find` and `findAll` for us.
 *
 * @since   0.1
 */
final class DoctrineArticleStorage extends EntityRepository implements ArticleStorage
{
    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->findBy([], [
            'year'  => 'DESC',
            'title' => 'ASC',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        return $this->findBy([
            'year'  => $year,
        ], [
            'year'  => 'DESC',
            'title' => 'ASC',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Article $article)
    {
        $em = $this->getEntityManager();
        $em->persist($article);
        $em->flush(); // probably not a good idea in a larger app

        return $article->getIdentifier();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($article)
    {
        if (!$article instanceof Article) {
            $article = $this->find($article);
            if (!$article) {
                throw new \UnexpectedValueException('article not found');
            }
        }

        $em = $this->getEntityManager();
        $em->remove($article);
        $em->flush(); // again, probalby not a good idea in a larger app
    }
}
