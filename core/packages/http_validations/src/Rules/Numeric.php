<?php

namespace src\Rules;

require_once __DIR__ . '/../Rule.php';

use src\Rule;

class Numeric extends Rule
{

    /** @var string */
    protected $message = "The :attribute contains invalid characters.";

    /**
     * Check $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return is_numeric($value);
    }
}
