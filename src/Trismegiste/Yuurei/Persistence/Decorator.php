<?php

/*
 * GraphRpg
 */

namespace Trismegiste\Yuurei\Persistence;

/**
 * Decorator is a decorator for repository
 */
abstract class Decorator implements RepositoryInterface
{

    protected $decorated;

    public function __construct(RepositoryInterface $wrapped)
    {
        $this->decorated = $wrapped;
    }

    public function createFromDb(array $struc)
    {
        return $this->decorated->createFromDb($struc);
    }

    public function persist(Persistable $doc)
    {
        return $this->decorated->persist($doc);
    }

    public function find(array $query = array(), array $fields = array())
    {
        return $this->decorated->find($query, $fields);
    }

    public function findByPk($id)
    {
        return $this->decorated->findByPk($id);
    }

    public function findOne(array $query = array(), array $fields = array())
    {
        return $this->decorated->findOne($query, $fields);
    }

}