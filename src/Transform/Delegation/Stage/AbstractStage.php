<?php

/*
 * Yuurei
 */

namespace Trismegiste\Yuurei\Transform\Delegation\Stage;

use Trismegiste\Alkahest\Transform\Delegation\MappingBuilder;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapArray;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapNullable;
use Trismegiste\Alkahest\Transform\Mediator\Colleague\MapScalar;
use Trismegiste\Alkahest\Transform\Transformer;
use Trismegiste\Yuurei\Transform\Mediator\Colleague\DateObject;
use Trismegiste\Yuurei\Transform\Mediator\Colleague\MongoInvariant;
use Trismegiste\Alkahest\Transform\Mediator\Mediator;
use Trismegiste\Alkahest\Transform\Mediator\TypeRegistry;

/**
 * Design Pattern : Builder
 * Component : Builder (abstract)
 *
 * This is a template for a builder of delegation of mapping
 * @see Transformer
 */
abstract class AbstractStage implements MappingBuilder
{

    /**
     * {@inheritDoc}
     */
    public function createChain()
    {
        return new Mediator();
    }

    /**
     * {@inheritDoc}
     */
    public function createNonObject(TypeRegistry $algo)
    {
        new MapArray($algo);
        new MapScalar($algo);
        new MapNullable($algo);
    }

    /**
     * {@inheritDoc}
     */
    public function createDbSpecific(TypeRegistry $algo)
    {
        new DateObject($algo);
        new MongoInvariant($algo);
    }

    /**
     * {@inheritDoc}
     * Default adapter for implementation of the interface
     */
    public function createBlackHole(TypeRegistry $algo)
    {

    }

}
