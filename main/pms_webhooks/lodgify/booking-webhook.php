<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

require_once __DIR__ . '/../../../core/const/pms_info_const.php';
require_once __DIR__ . '/../../../helpers/webhook_helper.php';
require_once __DIR__ . '/../../../core/system/client/parser/keys_mapper.php';
require_once __DIR__ . '/../../../core/includes/get_partner_and_partner_user_globally.php';
require_once __DIR__ . '/../../../helpers/manifest_global_helper.php';

use Core\System\ResponseInstance\HotelReservation\HotelReservation;

try {
    $pms_response = file_get_contents('php://input');
    $data = json_decode($pms_response, true);
    setPmsName(LODGIFY);
    $pms_name = getPmsName();

    storeWebhookLogs(['id' => 0, 'partner_id' => 0, 'pms_name' => $pms_name, 'url' => ''], $pms_response, json_encode(['data' => $_REQUEST['token']]), '', 1, 1);

    if(empty($_REQUEST['token']) || empty($data)){
        sendLogToSlack('Lodgify Webhook token or data missing', $data);
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);
        return;
    }

    $entity_type_array = config('db_config.partner_webhook_settings', 'type');
    $_REQUEST['token'] = str_replace('?','',$_REQUEST['token']);

    if (!empty($data) && key_exists(strtolower($data[0]['booking']['type']), $entity_type_array)) {
        $webhook_settings = getWebHookSettings(['pms_name' => $pms_name, 'credential_token' => base64_encode(trim($_REQUEST['token'])), 'webhook_type' => strtolower($data[0]['booking']['type'])], true);

        if (!empty($webhook_settings)) {
            $data_to_map_key = 'id';
            $booking = map_pms_keys_to_partner_keys('reservation', $data[0]['booking'], $pms_name);
            $cax_response = new HotelReservation($booking);
            foreach ($webhook_settings as $webhook_setting) {
                sendWebHookToPartnerUser($webhook_setting, $pms_response, json_encode($cax_response));
            }
        }

    }
    apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);
} catch (CaxException $caxException) {
    apiResponse($caxException->getCode(), $caxException->getData(), $caxException->getMessage());
}