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
    //$pms_response = '{"user_id":"manual_132470","code":"61SUXN","channel":"manual","start_date":"2023-05-21","end_date":"2023-05-26","checkin_time":"2023-05-21T15:00:00-04:00","checkout_time":"2023-05-26T11:00:00-04:00","nights":5,"guests":5,"adults":3,"children":2,"infants":0,"pets":0,"status":"accepted","listing":{"id":"828957578984975478","property_id":997170,"name":"Best place to live in the city","nickname":"Best place to live in the city","address":"7230 Darcel Avenue, Mississauga, ON, L4T 3T6, CA","picture_url":"https://a0.muscache.com/im/pictures/miso/Hosting-828957578984975478/original/e7146c87-cc3d-4fb0-ae69-30ffdc208b09.png?aki_policy=small","lat":"43.72070870","lng":"-79.63504710"},"child_reservations":[],"guest":{"id":"ae5456cdf4d48dceff144317753235ad7a3e7b8c","first_name":"Zain","last_name":null,"picture_url":null,"location":null,"phone":"+923001111111","phone_last_4":1111,"email":"zain@dummy.com"},"currency":"CAD","security_price":null,"security_price_formatted":null,"per_night_price":55.6,"per_night_price_formatted":"CA$55.60","base_price":278,"base_price_formatted":"CA$278.00","extras_price":null,"extras_price_formatted":null,"subtotal":"278.00","subtotal_formatted":"CA$278.00","tax_amount":null,"tax_amount_formatted":null,"guest_fee":null,"guest_fee_formatted":null,"total_price":"278.00","total_price_formatted":"CA$278.00","host_service_fee":null,"host_service_fee_formatted":null,"payout_price":0,"payout_price_formatted":null,"created_at":1681730637,"updated_at":1681730655,"sent_at":1681812450}';
    $data = json_decode($pms_response, true);
    setPmsName(HOSPITABLE);
    $pms_name = getPmsName();

    storeWebhookLogs(['id' => 0, 'partner_id' => 0, 'pms_name' => $pms_name, 'url' => basename($_SERVER['REQUEST_URI'])], $pms_response, json_encode($data), '', 1, 1);

    if(empty($_REQUEST['token']) || empty($data)){
        sendLogToSlack('Hospitable Webhook token or data missing', $data);
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);
        return;
    }

    $entity_type = config('db_config.partner_webhook_settings', 'type.booking');

    $webhook_settings = getWebHookSettings(
        ['pms_name' => $pms_name, 'pms_user_id' => 0, 'webhook_type' => $entity_type, 'credential_token' => base64_encode(trim($_REQUEST['token']))],
        true
    );

    if (!empty($webhook_settings)) {

        $booking = map_pms_keys_to_partner_keys('reservation_webhook', $data, $pms_name);
        $cax_response = new HotelReservation($booking);
        $cax_response->webhook_entity_type = $entity_type;
        $cax_response->pms_user_id = $data['user_id'] ?? null;

        foreach ($webhook_settings as $webhook_setting) {
            sendWebHookToPartnerUser($webhook_setting, $pms_response, json_encode($cax_response));
        }
    }

    apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);

} catch (CaxException $caxException) {
    apiResponse($caxException->getCode(), $caxException->getData(), $caxException->getMessage());
}