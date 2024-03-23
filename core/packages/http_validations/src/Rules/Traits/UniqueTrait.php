<?php

namespace src\Rules\Traits;

require_once __DIR__ . '/../../../../../../core/DB.php';

use DB;
use InvalidArgumentException;

trait UniqueTrait
{

    protected function checkExistince($param, $value)
    {
        $explode_params = explode(',', $param);
        return DB::executeStatement("SELECT id FROM $explode_params[0] WHERE $explode_params[1] = '$value'")->rowCount();
    }
}
