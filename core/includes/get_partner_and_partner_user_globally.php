<?php
if (!function_exists('getPartnerId')) {
    function getPartnerId()
    {
        global $global_partner;
        return $global_partner['id'] ?? null;
    }
}

if (!function_exists('getPartnerUserId')) {
    function getPartnerUserId()
    {
        global $global_partner_user;
        return $global_partner_user['id'] ?? null;
    }
}

if (!function_exists('getPmsName')) {
    function getPmsName()
    {
        global $global_partner_user;
        return $global_partner_user['pms_name'] ?? null;
    }
}

if (!function_exists('setPmsName')) {
    function setPmsName($pms_name)
    {
        global $global_partner_user;
        return $global_partner_user['pms_name'] = $pms_name;
    }
}

if (!function_exists('getUserCredentials')) {
    function getUserCredentials()
    {
        global $global_partner_user;
        return $global_partner_user['credentials'] ?? null;
    }
}

if (!function_exists('getUserCredentialToken')) {
    function getUserCredentialToken()
    {
        global $global_partner_user;
        return $global_partner_user['credential_token'] ?? null;
    }
}

if (!function_exists('setUserCredentials')) {
    function setUserCredentials($credentials = [])
    {
        global $global_partner_user;
        $global_partner_user['credentials'] = $credentials;
    }
}

?>