<?php

const DEFAULT_MESSAGE = '';

//rules keys
const NOT_EMPTY = 'required';
const SHOULD_NUMERIC = 'numeric';
const NOT_SPECIAL_CHARACTERS = 'specialCharacters';
const IN_ARRAY = 'inArray';

const VALIDATION_MESSAGE = [
    NOT_EMPTY => '{$input} must be required.',
    SHOULD_NUMERIC => '{$input} must be numeric value.',
    NOT_SPECIAL_CHARACTERS => 'Special character not allowed in {$input} field.',
    IN_ARRAY => 'Invalid value given in {$input} field.',
    DEFAULT_MESSAGE => 'Success'
];

//Validation array keys
const INPUT_NAME = 'input_name';
const RULES = 'rules';



?>