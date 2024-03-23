<?php

namespace src\Rules;

require_once __DIR__ . '/../Rule.php';

use src\Rule;

class Email extends Rule
{

    /** @var string */
    protected $message = "The :attribute is not a valid email.";

    /**
     * Check $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
