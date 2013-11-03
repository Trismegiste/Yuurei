<?php

/*
 * Yuurei
 */

namespace Trismegiste\Yuurei\Transform\Mediator\Colleague;

use Trismegiste\Yuurei\Transform\Mediator\AbstractMapper;

/**
 * DateObject is a transformer \MongoDate <=> DateTime
 */
class DateObject extends AbstractMapper
{

    /**
     * {@inheritDoc}
     */
    public function mapFromDb($var)
    {
        $ret = new \DateTime();
        $ret->setTimestamp($var->sec);
        return $ret;
    }

    /**
     * {@inheritDoc}
     */
    public function mapToDb($obj)
    {
        if (get_class($obj) == 'MongoDate') {
            // since this mapper is not responsible for MongoDate mapping
            // this case never happen. Anyway, I prefer to check in case
            // of future regression
            throw new \LogicException('Cannot transform MongoDate because reversed will be a DateTime');
        }
        $tmp = clone $obj;
        $tmp->setTimezone(new \DateTimeZone('UTC')); // @todo hardcoding is evil
        return new \MongoDate($tmp->getTimestamp());
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleFromDb($var)
    {
        return (gettype($var) == 'object' ) && (get_class($var) == 'MongoDate');
    }

    /**
     * {@inheritDoc}
     */
    public function isResponsibleToDb($var)
    {
        return (gettype($var) == 'object' ) && (get_class($var) == 'DateTime');
    }

}