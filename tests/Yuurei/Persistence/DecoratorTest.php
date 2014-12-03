<?php

/*
 * Yuurei
 */

namespace tests\Yuurei\Persistence;

/**
 * DecoratorTest tests the decorator
 */
class DecoratorTest extends \PHPUnit_Framework_TestCase
{

    protected $sut;

    protected function setUp()
    {
        $mock = $this->getMock('Trismegiste\Yuurei\Persistence\RepositoryInterface');
        $this->sut = $this->getMockForAbstractClass('Trismegiste\Yuurei\Persistence\Decorator', [$mock]);
    }

    public function testQuery()
    {
        $this->sut->find();
        $this->sut->findOne();
        $this->sut->findByPk(123);
        $this->sut->getCursor();
    }

    public function testPersistence()
    {
        $this->sut->createFromDb([]);
        $this->sut->persist($this->getMock('Trismegiste\Yuurei\Persistence\Persistable'));
    }

    public function testBatchPersist()
    {
        $this->sut->batchPersist([]);
    }

}