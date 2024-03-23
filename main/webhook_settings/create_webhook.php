<?php
try {
    require_once __DIR__ . '/../../validations/webhook_validation.php';

    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $partner_user_id = getPartnerUserId();
    $is_valid_credential_key = isValidCredentialToken($partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);
    $is_valid_request = webhookValidations($_REQUEST);

    if ($is_valid_api_key && $is_valid_credential_key && $is_valid_request) {

        $pms = new \Core\System\PMS();
        $pms->add_webhook($_REQUEST['type']);

        DB::executeStatement('INSERT INTO `partner_webhook_settings` (`partner_id`, `partner_user_id`, `type`, `url`)
        VALUES (:partner_id, :partner_user_id, :webhook_type, :url)',
            ['partner_id' => $partner_id, 'partner_user_id' => $partner_user_id, 'webhook_type' => $_REQUEST['type'], 'url' => $_REQUEST['url']]
        );

        apiResponse(CAX_SUCCESS_RESPONSE_CODE, [$_REQUEST], CAX_SUCCESS_MESSAGE);
    }

} catch (CaxException $caxException) {
    apiResponse($caxException->getCaxDefinedCode(), $caxException->getData(), $caxException->getCaxDefinedMessage());
}