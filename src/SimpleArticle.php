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
 * An implementation of articles that's just private properties and the
 * interface implementation.
 *
 * @since   0.1
 */
class SimpleArticle implements Article
{
    private $id;
    private $title;
    private $body;
    private $year;

    public function __construct($id=null)
    {
        $this->id = null === $id ? $id : intval($id);
    }

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
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }
}
