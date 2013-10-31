<?php

/*
 * Yuurei
 */

namespace tests\Yuurei\Example;

use Trismegiste\Yuurei\Persistence\Persistable;

/**
 * PhpFile is a ...
 *
 * @author florent
 */
class PhpFile implements Persistable
{

    protected $id;
    protected $statement;

    public function __construct(array $stmts)
    {
        $this->statement = $stmts;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(\MongoId $pk)
    {
        $this->id = $pk;
    }

    public function __toString()
    {
        $prettyPrinter = new \PHPParser_PrettyPrinter_Default();
        return $prettyPrinter->prettyPrint($this->statement);
    }

}