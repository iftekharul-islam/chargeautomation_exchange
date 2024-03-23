<?php
use src\Validator;

try {
    require_once __DIR__ . '/../../core/includes/header.php';
    require_once __DIR__ . '/../../core/packages/http_validations/Validator.php';

    $validator = new Validator;
    $validation = $validator->make($_REQUEST, [
        'name' => 'required|specialCharacters',
        'email' => 'required|email|unique:partners,email',
    ]);


    $validation->validate();

    if ($validation->fails()) {
        $errors = $validation->errors()->firstOfAll();
        apiResponse(CAX_VALIDATION_ERROR, null, $errors);
    } else {
        $api_key = generateUuId('partners', 'api_key');
        DB::executeStatement(
            'INSERT INTO `partners` (name, email, api_key) VALUES (:name, :email, :api_key)',
            ['name' => $_REQUEST['name'], 'email' => $_REQUEST['email'], 'api_key' => base64_encode($api_key)]
        );

        apiResponse(CAX_SUCCESS_RESPONSE_CODE, ['api_key' => $api_key], CAX_SUCCESS_MESSAGE_PARTNER_ONBOARD);
    }
} catch (CaxException $caxException) {
    apiResponse($caxException->getCode(), $caxException->getData(), $caxException->getMessage());
}