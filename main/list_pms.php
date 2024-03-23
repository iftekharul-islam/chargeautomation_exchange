<?php
try{
    require_once __DIR__ . '/../core/includes/header.php';

    if(!isset($http_headers[CAX_HTTP_REQUEST_API_KEY])){
        throwException(CAX_EXCEPTION_MESSAGES[CAX_PARTNER_UNAUTHORIZED_ERROR], CAX_PARTNER_UNAUTHORIZED_ERROR);
    }
    if(!isset($http_headers[CAX_HTTP_REQUEST_API_KEY])){
        throwException(CAX_EXCEPTION_MESSAGES[CAX_INVALID_CREDENTIAL_TOKEN_ERROR], CAX_INVALID_CREDENTIAL_TOKEN_ERROR);
    }

    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $partner_user_id = getPartnerUserId();
    $is_valid_credential_key = isValidCredentialToken($partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);

    if ($is_valid_api_key && $is_valid_credential_key) {
        $requested_pms = null;
        if(isset($_REQUEST['pms']) && !empty($_REQUEST['pms'])) {
            $requested_pms = strtolower($_REQUEST['pms']) ;
        }
        $get_pms = getPmsList($requested_pms);
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, $get_pms['data'], $get_pms['message'], $additional = null);
    }

} catch (CaxException $e) {
    apiResponse($e->getCode(), $e->getData(), $e->getMessage());
}