<?php

if (!function_exists('getPMSManifest')) {

    /**
     * Optional $pmsName
     * Returns the current Partner user's pms manifest configurations array
     * If $pmsName is not set then that will be loaded from the global session vars
     * @param null $pmsName
     * @return array|mixed
     */
    function getPMSManifest($pmsName = null)
    {
        global $global_partner_user;

        //Avoid Loading file again & again
        if (!empty($global_partner_user['manifest'])) {
            return $global_partner_user['manifest'];
        }

        $pmsName = $pmsName ?: getPmsName();

        if(!empty($pmsName)){
            $file = __DIR__ . '/../core/config/pms/' . $pmsName . '/manifest.json';

            if (file_exists($file)) {
                $json_data = file_get_contents($file);
                $global_partner_user['manifest'] = json_decode($json_data, true);

                //Append Custom Request Endpoints to Global manifest config.
                if(!empty($global_partner_user['manifest']['requests']['cax_custom_requests']['manifest_path'])) {
                    $file = __DIR__ . '/../'.$global_partner_user['manifest']['requests']['cax_custom_requests']['manifest_path'];
                    $requests = json_decode(file_get_contents($file), true);
                    $global_partner_user['manifest']['requests'] = array_merge($global_partner_user['manifest']['requests'], $requests);
                    unset($global_partner_user['manifest']['requests']['cax_custom_requests']);
                }

            } else {
                sendLogToSlack('Missing manifest.json file', ['File path' => $file]);
            }
        }

        return $global_partner_user['manifest'] ?? [];
    }
}

if (!function_exists('getManifestEndpointKey')) {

    /**
     * $request_name => eg. property or booking etc
     * $request_type => eg. property.list.read" or property.single.read or booking.list.read" etc
     * @param $request_name
     * @param $request_type
     * @return string
     */
    function getManifestEndpointKey($request_name, $request_type)
    {
        return getPMSManifest()['requests'][$request_name]['endpoint_keys'][$request_type] ?? null;
    }
}

if (!function_exists('isWebhookEnabledInManifest')) {

    /**
     * Check If Webhook Type supported by the Current PMs manifest.
     * $request_name => 'property' or 'booking' or guest ect
     * @param $webhook_type
     * @return bool
     */
    function isWebhookEnabledInManifest($webhook_type)
    {
        return getPMSManifest()['webhooks'][$webhook_type]['status'] ?? false;
    }
}

if (!function_exists('isManifestRequestAvailable')) {

    /**
     * Check If request Type supported by the Current PMs manifest.
     * $request_name => 'property' or 'booking' or guest ect
     * @param $request_name
     * @param bool $single
     * @param false $write
     * @return mixed|null
     */
    function isManifestRequestAvailable($request_name, $single = true, $write = false)
    {
        return getPMSManifest()['requests'][$request_name]['available'][$single ? 'single' : 'list'][$write ? 'write' : 'read']
            ?? false;
    }
}

if (!function_exists('getCAX_PMSExceptionCodes')) {
    /**
     * Get PMS generalized Error code by CAX
     * @param null $pms_name
     * @return array|mixed
     */
    function getCAX_PMSExceptionCodes($pms_name = null)
    {
        $path = getPMSManifest($pms_name)['exception_file'] ?? null;
        $path = __DIR__ . "/../$path.php";
        //core/system/pms/hostify/ExceptionCodes.php"

        if (file_exists($path)) {
            @include($path);
            return CAX_EXCEPTION_CODES ?? [];
        }

        return [];
    }
}

if (!function_exists('getPmsEndpointFilePath')) {
    function getPmsEndpointFilePath()
    {
        return !empty(getPmsName()) ? 'pms.' . getPmsName() . '.pms_endpoints' : null;
    }
}

if (!function_exists('getPmsRequestMapperFilePath')) {
    function getPmsRequestMapperFilePath($file_name)
    {
        return !empty(getPmsName()) ? 'pms.' . getPmsName() . '.pms_request_mapper.' . $file_name : null;
    }
}

if (!function_exists('getPmsResponseMapperFilePath')) {
    function getPmsResponseMapperFilePath($file_name)
    {
        return !empty(getPmsName()) ? 'pms.' . getPmsName() . '.pms_response_mapper.' . $file_name : null;
    }
}

if (!function_exists('getApiBaseUrl')) {
    function getApiBaseUrl()
    {
        if ($_ENV['APP_ENV'] != 'development' || !$_ENV['APP_DEBUG'] || $_ENV['APP_URL'] == 'https://cax.chargeautomation.com' ) {
            return getPMSManifest()['api_base_url'];
        } else {
            return getPMSManifest()['stage_api_base_url'];
        }
    }
}

?>