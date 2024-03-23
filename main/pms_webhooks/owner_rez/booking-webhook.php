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
    //$pms_response = '{"action":"entity_create","entity_id":326408,"entity_type":"booking","user_id":347317190}';
    $data = json_decode($pms_response, true);
    setPmsName(OWNER_REZ);
    $pms_name = getPmsName();
    //echo $pms_name;
    //exit();

    storeWebhookLogs(['id' => 0, 'partner_id' => 0, 'pms_name' => $pms_name, 'url' => ''], $pms_response, json_encode(['data' => '']), '', 1, 1);

    $entity_type_array = config('db_config.partner_webhook_settings', 'type');
    if (!empty($data) && key_exists($data['entity_type'], $entity_type_array)) {
        $webhook_settings = getWebHookSettings(['pms_name' => $pms_name, 'pms_user_id' => $data['user_id'], 'webhook_type' => $data['entity_type']]);
        if (!empty($webhook_settings)) {
            $data_to_map_key = ($data['entity_type'] == $entity_type_array['guest']) ? 'guest_id' : 'id';
            $booking = map_pms_keys_to_partner_keys('reservation', [$data_to_map_key => $data['entity_id']], $pms_name);
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