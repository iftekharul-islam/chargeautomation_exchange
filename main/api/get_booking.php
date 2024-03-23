<?php
/* file name get_booking
 * Get bookings form pms for partner user according his pms
 * set record to partner user after fetch from pms
 */


try {
    require_once __DIR__ . '/../../core/includes/header.php';
    require_once __DIR__ . '/../../core/system/PMS.php';

    $partner_id = getPartnerId();
    $is_valid_api_key = isValidApiKey($partner_id, $http_headers[CAX_HTTP_REQUEST_API_KEY]);
    $partner_user_id = getPartnerUserId();
    $is_valid_credential_key = isValidCredentialToken($partner_user_id, $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);

    if ($is_valid_api_key && $is_valid_credential_key) {
        $pms = new \Core\System\PMS();
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, $pms->get_booking(), CAX_SUCCESS_MESSAGE, $additional = null);
    }

} catch (CaxException $e) {
    apiResponse($e->getCaxDefinedCode(), $e->getData(), $e->getCaxDefinedMessage());
}