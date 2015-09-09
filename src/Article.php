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
 * A *Header Interface* for articles.
 *
 * http://martinfowler.com/bliki/HeaderInterface.html
 *
 * @since   0.1
 */
interface Article
{
    public function getIdentifier();

    public function getTitle();

    public function setTitle($title);

    public function getBody();

    public function setBody($body);

    public function getYear();

    public function setYear($year);
}
