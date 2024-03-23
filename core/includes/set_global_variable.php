<?php

function set_partner_user($partner)
{
    global $http_headers;
    global $global_partner_user;

    if (!empty($partner) && !empty($http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN])) {
        $credential_token = base64_encode($http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]);
        $partner_user = DB::executeStatement("SELECT * FROM `partner_users` WHERE `partner_id`='{$partner['id']}' AND `credential_token` = '{$credential_token}'");
        $partner_user = $partner_user->fetch(\PDO::FETCH_ASSOC);

        if (!empty($partner_user)) {
            $global_partner_user = [
                'id' => $partner_user['id'],
                'pms_name' => $partner_user['pms_name'],
                'credentials' => json_decode($partner_user['credentials'], true),
                'credential_token' => $http_headers[CAX_HTTP_REQUEST_CREDENTIAL_TOKEN]
            ];
        }
    }
}


function set_partner()
{
    global $http_headers;
    global $global_partner;

    if (!empty($http_headers[CAX_HTTP_REQUEST_API_KEY])) {
        $api_key = base64_encode($http_headers[CAX_HTTP_REQUEST_API_KEY]);
        $partner = DB::executeStatement("SELECT * FROM `partners` WHERE `api_key`='{$api_key}'");
        $partner = $partner->fetch(\PDO::FETCH_ASSOC);

        if (!empty($partner)) {
            $global_partner = [
                'id' => $partner['id'],
                'name' => $partner['name'],
                'email' => $partner['email'],
                'api_key' => $http_headers[CAX_HTTP_REQUEST_API_KEY]
            ];
        }

    }

    return $global_partner;
}

$partner = set_partner();
set_partner_user($partner);
