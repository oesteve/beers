<?php

namespace App\Application\Query;

interface QueryBus
{
    /**
     * @param Query $query
     *
     * @return object
     */
    public function query($query);
}
