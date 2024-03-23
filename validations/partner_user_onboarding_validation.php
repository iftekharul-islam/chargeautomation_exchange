<?php
require_once __DIR__ . '/../core/includes/header.php';
require_once __DIR__ . '/../core/packages/http_validations/Validator.php';

use src\Validator;

/**
 * @param $request
 * @return bool
 * @throws CaxException
 */
function onboardingValidations($request)
{
    $validator = new Validator;
    $validation = $validator->make($_REQUEST, [
        'name' => 'required|specialCharacters',
        'credentials' => 'required',
    ]);

    $validation->validate();
    if ($validation->fails()) {
        $errors = $validation->errors();
        validationError($errors);
    }

    $manifest = getPMSManifest(strtolower($request['name']));

    //Validate request PMS name
    if (empty($manifest)) {
        throwException(CAX_EXCEPTION_MESSAGES[CAX_INVALID_PMS], CAX_INVALID_PMS);
    }

    $credentials = $manifest['user_onboard']['credentials'] ?? [];

    foreach ($credentials as $credential) {
        if (empty($request['credentials'][$credential])) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_INVALID_CREDENTIALS_ERROR], CAX_INVALID_CREDENTIALS_ERROR);
        }
    }

    return true;
}
