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

use Illuminate\Database\Eloquent\Model;

/**
 * An `Article` implementation for Laraval's Eloquent.
 *
 * This mostly the same, we'll use the magic getters/setters that
 * `Model` provides.
 *
 * @since   0.1
 */
class EloquentArticle extends Model implements Article
{
    public $timestamps = false;
    protected $table = 'articles';

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getYear()
    {
        return $this->publishyear;
    }

    public function setYear($year)
    {
        $this->publishyear = $year;
    }
}
