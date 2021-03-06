<?php

/*
 * Yuurei
 */

namespace tests\Yuurei\Example;

use tests\Yuurei\Persistence\ConnectorTest;
use Trismegiste\Yuurei\Facade\Provider;

/**
 * FunWithParser tests the persistence capabilities of Yuurei by storing
 * a php source code parsed AST with the PHPParser library.
 */
class FunWithParserTest extends \PHPUnit_Framework_TestCase
{

    protected $collection;
    protected $repo;

    protected function createBuilder()
    {
        return new \Trismegiste\Yuurei\Transform\Delegation\Stage\Invocation();
    }

    protected function setUp()
    {
        $this->refl = new \ReflectionClass('tests\Yuurei\Fixtures\Branch');
        $test = new ConnectorTest();
        $this->collection = $test->testCollection();
        $facade = new Provider($this->collection);
        $this->repo = $facade->createRepository($this->createBuilder());
    }

    public function testInit()
    {
        $this->collection->drop();
    }

    public function testParsing()
    {

        $parser = new \PHPParser_Parser(new \PHPParser_Lexer());
        $code = file_get_contents($this->refl->getFileName());
        $record = new PhpFile($parser->parse($code));
        $this->repo->persist($record);

        return (string) $record->getId();
    }

    protected function stripWhiteSpace($str)
    {
        return preg_replace('#\s+#', ' ', $str);
    }

    /**
     * @depends testParsing
     */
    public function testCompiling($pk)
    {
        $ret = $this->repo->findByPk($pk);
        $code = file_get_contents($this->refl->getFileName());
        $this->assertEquals($this->stripWhiteSpace($code), $this->stripWhiteSpace('<?php ' . $ret));
    }

}