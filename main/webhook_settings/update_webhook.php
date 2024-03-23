<?php
try {
    require_once __DIR__ . '/../../validations/webhook_validation.php';

    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $partner_user_id = getPartnerUserId();
    $is_valid_credential_key = isValidCredentialToken($partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);
    $is_valid_request = webhookValidations($_REQUEST);

    if ($is_valid_api_key && $is_valid_credential_key && $is_valid_request) {

        $setting = DB::executeStatement("SELECT * FROM `partner_webhook_settings` WHERE `id`='{$_REQUEST['id']}' AND `partner_id`='{$partner_id}' AND `partner_user_id`='{$partner_user_id}'");
        $setting = $setting->fetch(\PDO::FETCH_ASSOC);

        if (empty($setting)) {
            throw new \CaxException('Webhook not found.', CAX_VALIDATION_ERROR);
        }

        $pms = new \Core\System\PMS();
        $pms->update_webhook($setting['type']);

        DB::executeStatement("UPDATE `partner_webhook_settings` SET  `url`='{$_REQUEST['url']}' WHERE `id`='{$_REQUEST['id']}' AND `partner_id`='{$partner_id}' AND `partner_user_id`='{$partner_user_id}'");
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, ['id' => $setting['id'], 'type' => $setting['webhook_type'], 'url'=> $_REQUEST['url']], CAX_SUCCESS_MESSAGE);
    }

} catch (CaxException $caxException) {
    apiResponse($caxException->getCaxDefinedCode(), $caxException->getData(), $caxException->getCaxDefinedMessage());
}