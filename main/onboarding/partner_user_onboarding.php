<?php
try {

//    //TODO::Remove
//    sendLogToSlack('Generate  Oauth redirection link before partner_user_onboarding_validation included', [$_REQUEST]);


    require_once __DIR__ . '/../../validations/partner_user_onboarding_validation.php';
    require_once __DIR__ . '/../../helpers/partner_user_onbaording_helper.php';

    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $is_valid_request = onboardingValidations($_REQUEST);

    if($is_valid_api_key && $is_valid_request){
        $credential_token = generateUuId('partner_users', 'credential_token');
        DB::executeStatement(
            'INSERT INTO `partner_users` (partner_id, pms_name, pms_user_id, credential_token, credentials) VALUES (:partner_id, :pms_name, :pms_user_id, :credential_token, :credentials)',
            ['partner_id' => $partner_id, 'pms_name' => $_REQUEST['name'], 'pms_user_id' => 0, 'credential_token' => base64_encode($credential_token), 'credentials' => json_encode($_REQUEST['credentials'])]
        );

        $partner_user_id = DB::getConnection()->lastInsertId();

        partnerUserOnboardResponse($_REQUEST['name'], $partner_user_id, $credential_token, $_REQUEST['redirect_uri'] ?? '');
    }

} catch (CaxException $caxException) {
    apiResponse($caxException->getCaxDefinedCode(), $caxException->getData(), $caxException->getCaxDefinedMessage());
}