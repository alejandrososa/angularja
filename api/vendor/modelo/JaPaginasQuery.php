<?php

use Base\JaPaginasQuery as BaseJaPaginasQuery;

/**
 * Skeleton subclass for performing query and update operations on the 'ja_paginas' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class JaPaginasQuery extends BaseJaPaginasQuery
{
    public function recientes($nbDays = 10)
    {
        return $this->orderByFechaCreado(array('min' => time() - $nbDays * 24 * 60 * 60));
    }

    public function masRecientesPrimero()
    {
        return $this->orderByFechaCreado('desc');
    }
}
