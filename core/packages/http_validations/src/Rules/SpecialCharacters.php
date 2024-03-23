<?php

namespace src\Rules;

require_once __DIR__ . '/../Rule.php';

use src\Rule;

class SpecialCharacters extends Rule
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
        return preg_match("/^[a-zA-Z0-9-.@_&' ]+$/", $value);
    }
}
