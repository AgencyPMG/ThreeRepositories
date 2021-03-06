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

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentArticleRepositoryTest extends TestCase
{
    private $capsule;

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddWithInvalidClassCausesError()
    {
        $this->repo->add(new SimpleArticle());
    }

    protected function setUp()
    {
        $this->capsule = new Capsule();
        $this->capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'prefix'    => '',
        ], 'default');
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
        $this->capsule
            ->connection('default')
            ->getSchemaBuilder()
            ->create('articles', function ($table) {
                $table->increments('id');
                $table->text('title');
                $table->text('body');
                $table->integer('publishyear');
            });

        $this->repo = new EloquentArticleRepository();
    }

    protected function createArticle()
    {
        return new EloquentArticle();
    }
}
