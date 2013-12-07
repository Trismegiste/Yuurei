<?php

/*
 * Yuurei
 */

namespace Trismegiste\Yuurei\Persistence;

/**
 * CollectionIterator is an iterator against a MongoDb Repository
 */
class CollectionIterator implements \Iterator
{

    protected $cursor;
    protected $factory;

    public function __construct(\MongoCursor $cursor, RepositoryInterface $factory)
    {
        $this->cursor = $cursor;
        $this->factory = $factory;
    }

    public function current()
    {
        return $this->factory->createFromDb($this->cursor->current());
    }

    public function key()
    {
        return $this->cursor->key();
    }

    public function next()
    {
        $this->cursor->next();
    }

    public function rewind()
    {
        $this->cursor->rewind();
    }

    public function valid()
    {
        return $this->cursor->valid();
    }

}