<?php
try {
    require_once __DIR__ . '/../../core/includes/header.php';

    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $partner_user_id = getPartnerUserId();
    $is_valid_credential_key = isValidCredentialToken($partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);

    if ($is_valid_api_key && $is_valid_credential_key) {
        $result=DB::executeStatement("SELECT `id`,`type`,`url` FROM `partner_webhook_settings` WHERE `partner_id`='{$partner_id}' AND `partner_user_id`='{$partner_user_id}'");
        $result=$result->fetchAll(PDO::FETCH_ASSOC);
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, $result, CAX_SUCCESS_MESSAGE);
    }

} catch (CaxException $caxException) {
    apiResponse($caxException->getCaxDefinedCode(), $caxException->getData(), $caxException->getCaxDefinedMessage());
}