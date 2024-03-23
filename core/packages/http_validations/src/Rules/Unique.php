<?php

namespace src\Rules;

require_once __DIR__ . '/../Rule.php';
require_once __DIR__ . '/../Rules/Traits/UniqueTrait.php';

use src\Rule;

class Unique extends Rule
{
    use Traits\UniqueTrait;

    /** @var string */
    protected $message = "This :attribute already exists.";

    /** @var array */
    protected $fillableParams = ['unique'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        return empty($this->checkExistince($this->parameter('unique'), $value));
    }
}
