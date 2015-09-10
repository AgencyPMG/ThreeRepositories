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
 * An `ArticleRepository` implementation backed by plain old PDO and embedded
 * SQL.
 *
 * @since   0.1
 */
final class PdoArticleRepository implements ArticleRepository
{
    const TABLE = 'articles';

    /**
     * @var PDO
     */
    private $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $stm = $this->conn->prepare($this->getSelect().' WHERE id = :id LIMIT 1');
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        $res = $stm->fetch();
        $stm->closeCursor();

        return $res ? $this->toObject($res) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $stm = $this->conn->query(
            $this->getSelect().' ORDER BY publish_year DESC, title ASC'
        );
        $out = $this->statementToObjects($stm);
        $stm->closeCursor();

        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        $stm = $this->conn->prepare(
            $this->getSelect().' WHERE publish_year = :year ORDER BY publish_year DESC, title ASC'
        );
        $stm->bindValue(':year', $year, \PDO::PARAM_INT);
        $stm->execute();
        $out = $this->statementToObjects($stm);
        $stm->closeCursor();

        return $out;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Article $article)
    {
        $id = $article->getIdentifier();
        $params = [
            ':title'    => $article->getTitle(),
            ':body'     => $article->getBody(),
            ':year'     => $article->getYear(),
        ];
        $bind = [
            ':year'     => \PDO::PARAM_INT,
        ];

        if ($id) {
            $sql = 'UPDATE '.self::TABLE.' SET title = :title, body = :body, publish_year = :year WHERE id = :id';
            $params[':id'] = $id;
            $bind[':id'] = \PDO::PARAM_INT;
        } else {
            $sql = 'INSERT INTO '.self::TABLE.' (title, body, publish_year) VALUES (:title, :body, :year)';
        }

        $stm = $this->conn->prepare($sql);
        foreach ($params as $name => $val) {
            $stm->bindValue(
                $name,
                $val,
                isset($bind[$name]) ? $bind[$name] : \PDO::PARAM_STR
            );
        }
        $stm->execute();

        return $id ? $id : intval($this->conn->lastInsertId());
    }

    /**
     * {@inheritdoc}
     */
    public function remove($article)
    {
        $stm = $this->conn->prepare('DELETE FROM '.self::TABLE.' WHERE id = :id');
        $stm->bindValue(
            ':id',
            $article instanceof Article ? $article->getIdentifier() : $article,
            \PDO::PARAM_INT
        );
        $stm->execute();
    }

    // may make more sense to use a factory object here, but
    // let's keep this somewhat simple.
    private function toObject(array $row)
    {
        $article = new SimpleArticle($row['id']);
        $article->setTitle($row['title']);
        $article->setBody($row['body']);
        $article->setYear($row['publish_year']);

        return $article;
    }

    private function statementToObjects(\PDOStatement $stm)
    {
        // could very easily use an iterator or a generator here
        // with big data sets, again, let's keep it simple.
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        return array_map([$this, 'toObject'], $stm->fetchAll());
    }

    private function getSelect()
    {
        return 'SELECT id, title, body, publish_year FROM '.self::TABLE;
    }
}
