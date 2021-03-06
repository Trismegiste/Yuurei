<?php

namespace tests\Yuurei\Fixtures;

use Trismegiste\Yuurei\Persistence\Persistable;
use Trismegiste\Yuurei\Persistence\PersistableImpl;

class AOPersistable implements Persistable
{

    use PersistableImpl;

    // we must wrap the ArrayObject and cannot extends it because PHP
    // cannot create internal class without calling the constructor
    protected $collection;

    public function __construct(array $array = [])
    {
        $this->collection = new \ArrayObject($array);
    }

    public function getCollection()
    {
        return $this->collection;
    }

}