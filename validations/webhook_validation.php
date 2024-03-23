<?php
require_once __DIR__ . '/../core/includes/header.php';
require_once __DIR__ . '/../core/packages/http_validations/Validator.php';

use src\Validator;

function webhookValidations($request)
{
    $validator = new Validator;
    $validation = $validator->make($_REQUEST, [
        'url' => 'required|validURL',
    ]);

    $validation->validate();
    if ($validation->fails()) {
        $errors = $validation->errors();
        validationError($errors);
    }

    $type_array = config('db_config.partner_webhook_settings', 'type');
    if (!array_key_exists($_REQUEST['type'], $type_array)) {
        throwException(CAX_EXCEPTION_MESSAGES[CAX_INVALID_TYPE], CAX_VALIDATION_ERROR);
    }

    return true;
}