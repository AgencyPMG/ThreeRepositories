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

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManager;

class DoctrineArticleRepositoryTest extends TestCase
{
    private $em;

    protected function setUp()
    {
        $config = Setup::createXMLMetadataConfiguration([
            __DIR__.'/../src/Resources/doctrine',
        ], true);
        $this->em = EntityManager::create([
            'driver'    => 'pdo_sqlite',
            'memory'    => true,
        ], $config);

        $tool = new SchemaTool($this->em);
        $tool->createSchema($this->em->getMetadataFactory()->getAllMetadata());

        $this->repo = $this->em->getRepository(SimpleArticle::class);
    }

    protected function createArticle()
    {
        return new SimpleArticle();
    }
}
