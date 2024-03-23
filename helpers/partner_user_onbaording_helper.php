<?php

require_once __DIR__ . '/../core/includes/set_global_variable.php';

/**
 * Return response regarding to pms by checking require_redirection for Oauth
 * @param $pms_name
 * @param $partner_user_id
 * @param $credential_token
 * @param $redirect_uri
 */
function partnerUserOnboardResponse($pms_name, $partner_user_id, $credential_token, $redirect_uri = '')
{

    global $global_partner;
    global $http_headers;

    switch ($pms_name) {

        case 'owner_rez':
        case 'octorate':
            /**
             * @var $pms \Core\System\pms\owner_rez\PMS|\Core\System\pms\octorate\PMS
             */
            //OwnerRez, octorate required OAuth redirection
            $pms_path = '\Core\System\pms\\' . $pms_name . '\PMS';
            $pms = new $pms_path(false);
            $url = $pms::oauth_url();//TODO

            $url .= '&state=' . $partner_user_id . '__' . hash_hmac('sha256', $partner_user_id, base64_encode($credential_token), false);
            $url .= '__' . base64_encode($redirect_uri);
            $url .= '__' . $pms_name;


            sendLogToSlack("OwnerRez/Octorate Oauth redirection link: $url");

            apiResponse(
                CAX_SUCCESS_RESPONSE_CODE,
                [
                    'url' => $url,
                    'require_redirection' => true,
                    'credential_token' => $credential_token
                ],
                CAX_AUTHENTICATION_REQUIRED
            );

            break;

        case 'opera': //TODO
            apiResponse(
                CAX_SUCCESS_RESPONSE_CODE,
                [
                    'url' => '',
                    'require_redirection' => false,
                    'credential_token' => $credential_token
                ],
                CAX_SUCCESS_MESSAGE_PARTNER_USER_ONBOARD
            );
            break;

        default:

            $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN] = $credential_token;
            set_partner_user($global_partner);

            $pms = new \Core\System\PMS();
            $pms->make_auth();

            apiResponse(CAX_SUCCESS_RESPONSE_CODE,
                [
                    'url' => '',
                    'require_redirection' => false,
                    'credential_token' => $credential_token
                ],
                CAX_SUCCESS_MESSAGE_PARTNER_USER_ONBOARD
            );
            break;
    }
}