<?php

/*
 * Yuurei
 */

namespace Trismegiste\Yuurei\Persistence;

/**
 * A contract meaning this object has a primary key
 */
interface Persistable
{

    function getId();

    function setId(\MongoId $pk);
}
