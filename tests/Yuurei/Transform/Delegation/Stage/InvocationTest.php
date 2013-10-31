<?php

/*
 * Yuurei
 */

namespace tests\Yuurei\Transform\Delegation\Stage;

use Trismegiste\Yuurei\Transform\Delegation\Stage\Invocation;
use tests\Yuurei\Fixtures;
use Trismegiste\Yuurei\Transform\Mediator\Colleague\MapObject;

/**
 * test for Mediator created by Invocation builder
 *
 * @author flo
 */
class InvocationTest extends AbstractStageTest
{

    protected function createBuilder()
    {
        return new Invocation();
    }

    public function getSampleTree()
    {
        $obj = new \stdClass();
        $obj->answer = 42;
        $dump = array(MapObject::FQCN_KEY => 'stdClass', 'answer' => 42);

        $obj2 = new Fixtures\Cart("86 fdfg de fdf");
        $obj2->info = 'nothing to say';
        $obj2->addItem(3, new Fixtures\Product('EF85L', 1999));
        $obj2->addItem(1, new Fixtures\Product('Bike', 650));

        $fixture = 'tests\Yuurei\Fixtures';
        $dump2 = array(
            MapObject::FQCN_KEY => $fixture . '\Cart',
            'address' => '86 fdfg de fdf',
            'info' => 'nothing to say',
            'notInitialized' => null,
            'row' => array(
                0 => array(
                    'qt' => 3,
                    'item' => array(
                        MapObject::FQCN_KEY => $fixture . '\Product',
                        'title' => 'EF85L',
                        'price' => 1999
                    )
                ),
                1 => array(
                    'qt' => 1,
                    'item' => array(
                        MapObject::FQCN_KEY => $fixture . '\Product',
                        'title' => 'Bike',
                        'price' => 650,
                    )
                )
            )
        );

        $obj3 = new Fixtures\CartPlus();
        $obj3->addItem(3, new Fixtures\Product('EF85L', 1999));
        $dump3 = [
            MapObject::FQCN_KEY => $fixture . '\CartPlus',
            'row' => [
                MapObject::FQCN_KEY => 'SplObjectStorage',
                'content' => [
                    'key' => [
                        [
                            MapObject::FQCN_KEY => $fixture . '\Product',
                            'title' => 'EF85L',
                            'price' => 1999
                        ]
                    ],
                    'value' => [3]
                ]
            ]
        ];

        return array(array($obj, $dump), array($obj2, $dump2), [$obj3, $dump3]);
    }

    public function getDataToDb()
    {
        $data = parent::getDataToDb();
        return array_merge($data, $this->getSampleTree());
    }

    public function getDataFromDb()
    {
        $data = parent::getDataFromDb();
        return array_merge($data, $this->getSampleTree());
    }

    public function testRestoreWithNonTrivialConstruct()
    {
        $obj = new Fixtures\VerifMethod(100);
        $dump = $this->mediator->recursivDesegregate($obj);
        $restore = $this->mediator->recursivCreate($dump);
        $this->assertInstanceOf('tests\Yuurei\Fixtures\VerifMethod', $restore);
        $this->assertEquals(119.6, $restore->getTotal());
    }

    /**
     * @expectedException \DomainException
     */
    public function testRootClassEmpty()
    {
        $obj = $this->mediator->recursivCreate(array(MapObject::FQCN_KEY => null, 'answer' => 42));
    }

    /**
     * @expectedException \DomainException
     */
    public function testLeafClassEmpty()
    {
        $obj = $this->mediator->recursivCreate(
                array(
                    MapObject::FQCN_KEY => 'stdClass',
                    'child' => array(MapObject::FQCN_KEY => null, 'answer' => 42)
                )
        );
    }

    /**
     * @expectedException \DomainException
     */
    public function testRootClassNotFound()
    {
        $this->mediator->recursivCreate(array(MapObject::FQCN_KEY => 'Snark', 'answer' => 42));
    }

    /**
     * @expectedException \DomainException
     */
    public function testLeafClassNotFound()
    {
        $obj = $this->mediator->recursivCreate(
                array(
                    MapObject::FQCN_KEY => 'stdClass',
                    'child' => array(MapObject::FQCN_KEY => 'Snark', 'answer' => 42)
                )
        );
    }

    public function testSkippable()
    {
        $obj = new Fixtures\IntoVoid();
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertNull($dump);
    }

    public function testChildSkippable()
    {
        $obj = new \stdClass();
        $obj->dummy = new Fixtures\IntoVoid();
        $obj->product = new Fixtures\Product("aaa", 23);
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertNull($dump['dummy']);
        $this->assertNotNull($dump['product']);
    }

    public function testCleanable()
    {
        $obj = new Fixtures\Bear();
        $dump = $this->mediator->recursivDesegregate($obj);
        $this->assertNull($dump['transient']);
        $this->assertEquals(42, $dump['answer']);
        $restore = $this->mediator->recursivCreate($dump);
        $this->assertEquals(range(1, 10), $restore->getTransient());
    }

}
