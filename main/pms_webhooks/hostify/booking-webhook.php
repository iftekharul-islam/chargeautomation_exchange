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

    //$pms_response = '{"reservation":{"id":"300095166","planned_arrival":"13:00:00", "status_code":"8"}}';
    $data = json_decode($pms_response, true)['reservation'] ?? [];
    $data = is_array($data) ? $data : [];

    //In cancel webhook If only Status Code is given map Status Code to Status field as cancelled
    if(isset($data['status_code']) && !isset($data['status']) && (string) $data['status_code'] == '8') {
        $data['status'] = 'cancelled';
    }

    setPmsName(HOSTIFY);
    $pms_name = getPmsName();

    storeWebhookLogs(['id' => 0, 'partner_id' => 0, 'pms_name' => $pms_name, 'url' => $_SERVER['REQUEST_URI']], $pms_response, json_encode($data), '', 1, 1);

    if(empty($_REQUEST['token']) || empty($data)){
        sendLogToSlack('Hostify Webhook token or data missing', $data);
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);
        return;
    }

    $entity_type = config('db_config.partner_webhook_settings', 'type.booking');
    $_REQUEST['token'] = str_replace('?','',$_REQUEST['token']);
    $webhook_settings = getWebHookSettings(['pms_name' => $pms_name, 'pms_user_id' => 0, 'webhook_type' => $entity_type, 'credential_token' => base64_encode(trim($_REQUEST['token']))], true);


    if (!empty($webhook_settings)) {

        $booking = map_pms_keys_to_partner_keys('reservation', $data, $pms_name);
        $cax_response = new HotelReservation($booking);
        $cax_response->webhook_entity_type = $entity_type;
        $cax_response->pms_user_id = $data['user_id'] ?? null;
        foreach ($webhook_settings as $webhook_setting) {
            sendWebHookToPartnerUser($webhook_setting, $pms_response, json_encode($cax_response));
        }
    }

    apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);

} catch (CaxException $caxException) {

    sendLogToSlack('Hostify Webhook Failed',
        [$caxException->getCode(), $caxException->getData(), $caxException->getMessage()]
    );

    apiResponse($caxException->getCode(), $caxException->getData(), $caxException->getMessage());
}