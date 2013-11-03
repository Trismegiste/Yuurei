<?php

/*
 * Yuurei
 */

namespace tests\Yuurei\Example;

use Trismegiste\Yuurei\Persistence\Persistable;

/**
 * PhpFile wraps a parsed php source AST
 */
class PhpFile implements Persistable
{

    use \Trismegiste\Yuurei\Persistence\PersistableImpl;

    protected $statement;

    public function __construct(array $stmts)
    {
        $this->statement = $stmts;
    }

    public function __toString()
    {
        $prettyPrinter = new \PHPParser_PrettyPrinter_Default();
        return $prettyPrinter->prettyPrint($this->statement);
    }

}