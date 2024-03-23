<?php
try {
    require_once __DIR__ . '/../../validations/partner_user_onboarding_validation.php';
    require_once __DIR__ . '/../../helpers/partner_user_onbaording_helper.php';



    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $partner_user_id = getPartnerUserId();
    $is_valid_credential_key = isValidCredentialToken($partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);
    $is_valid_request = onboardingValidations($_REQUEST);

    if ($is_valid_api_key && $is_valid_credential_key && $is_valid_request) {
        $credential_token = base64_encode($http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);
        DB::executeStatement(
            'UPDATE `partner_users` SET pms_name=:pms_name, credentials=:credentials WHERE credential_token=:credential_token AND partner_id=:partner_id',
            ['pms_name' => $_REQUEST['name'], 'credentials' => json_encode($_REQUEST['credentials']), 'credential_token' => $credential_token, 'partner_id' => $partner_id]
        );

        partnerUserOnboardResponse($_REQUEST['name'], $partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN], $_REQUEST['redirect_uri'] ?? '');
    }

} catch (CaxException $caxException) {
    apiResponse($caxException->getCaxDefinedCode(), $caxException->getData(), $caxException->getCaxDefinedMessage());
}
