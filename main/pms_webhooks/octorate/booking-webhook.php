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

    //Sample Response
    /*$pms_response = '{
        "content" : "{\"cancelPenality\":-1,\"cityTaxZero\":false,\"extraIncluded\":[],\"json\":{},\"loyaltyDiscount\":false,\"refer\":\"YB4JG4\",\"channelId\":288,\"channelRefer\":\"YB4JG4\",\"status\":\"CONFIRMED\",\"checkin\":\"2023-09-22T10:00:00Z[UTC]\",\"checkout\":\"2023-09-23T22:00:00Z[UTC]\",\"createTime\":\"2023-09-14T13:15:02Z[UTC]\",\"updateTime\":\"2023-09-14T13:15:02Z[UTC]\",\"children\":0,\"guests\":[{\"checkin\":\"2023-09-22\",\"checkout\":\"2023-09-24\",\"city\":\"\",\"email\":\"Natasha@octorate.com\",\"familyName\":\"Romanoff\",\"givenName\":\"Natasha\",\"language\":\"EN\",\"phone\":\"\",\"source\":\"USER\",\"type\":\"BOOKER\"}],\"infants\":0,\"phone\":\"\",\"roomGross\":290.00,\"totalGross\":290.00,\"totalGuest\":2,\"accommodation\":{\"address\":\"via filippo caruso\",\"checkinEnd\":20,\"checkinStart\":12,\"checkout\":12,\"city\":\"ROMA\",\"currency\":\"EUR\",\"id\":\"761373\",\"latitude\":41.8489657,\"longitude\":12.5764685,\"name\":\"chargeautomation  Test Api Hotel\",\"phoneNumber\":\"+3906060606\",\"timeZone\":\"Europe/Rome\",\"timeZoneOffset\":\"+01:00\",\"zipCode\":\"00173\"},\"arrivalTime\":\"12:00:00\",\"autoLoginParam\":\"960891e64235cd61365f33782227b609ac65ca060c9dd69d1b3d61272b2e28abf8b06cae2a158323c352a6bf739d7118\",\"channelName\":\"octoevo autosubmit\",\"currency\":\"EUR\",\"firstName\":\"Natasha\",\"freeCancellation\":true,\"grouped\":false,\"guestMailAddress\":\"Natasha@octorate.com\",\"guestsList\":\"Natasha Romanoff\",\"id\":104369222,\"itemCompleted\":false,\"lastName\":\"Romanoff\",\"noShow\":false,\"paymentStatus\":\"UNPAID\",\"paymentType\":\"UNKNOWN\",\"payments\":[],\"priceBreakdown\":[{\"type\":\"DAILY_ROOM_PRICE\",\"name\":null,\"createTime\":null,\"day\":\"2023-09-21T22:00:00Z[UTC]\",\"price\":145.00,\"reference\":\"62384698\",\"externalId\":null,\"included\":true,\"product\":null,\"quantity\":null},{\"type\":\"DAILY_ROOM_PRICE\",\"name\":null,\"createTime\":null,\"day\":\"2023-09-22T22:00:00Z[UTC]\",\"price\":145.00,\"reference\":\"62384699\",\"externalId\":null,\"included\":true,\"product\":null,\"quantity\":null},{\"type\":\"ROOM_NET\",\"name\":null,\"createTime\":null,\"day\":null,\"price\":290.00,\"reference\":null,\"externalId\":null,\"included\":true,\"product\":null,\"quantity\":null},{\"type\":\"VAT\",\"name\":null,\"createTime\":null,\"day\":null,\"price\":0.00,\"reference\":null,\"externalId\":null,\"included\":true,\"product\":null,\"quantity\":null}],\"product\":590490,\"roomName\":\"Not refundable\",\"roomNameGuest\":\"Not refundable\",\"rooms\":1,\"totalChildren\":0,\"totalInfants\":0,\"totalPaid\":0.00,\"touristTax\":0}",
        "createTime" : "2023-09-14T13:15:03Z[UTC]",
        "hmac" : "4ee3200494c2ab8c40bb353483708ae1c1752a1c",
        "id" : 61355135,
        "nextTry" : "2023-09-14T13:20:21.222Z[UTC]",
        "reference" : "104369222",
        "retry" : 10,
        "subscription" : {
            "apiMember" : 570,
            "createTime" : "2023-09-14T13:09:25Z[UTC]",
            "enabled" : true,
            "endpoint" : "https://master.chargeautomation.com/api/booking_automation?CAX_OCTORATE_TEST_WEBHOOK=true",
            "id" : 1078,
            "priority" : 1,
            "processTime" : "2023-09-14T13:10:19Z[UTC]",
            "type" : "RESERVATION_CREATED"
        },
        "type" : "RESERVATION_CREATED"
    }';*/

    $pms_response = file_get_contents('php://input');
    $data = json_decode($pms_response, true) ?? [];
    $data = is_array($data) ? $data : [];

    setPmsName(OCTORATE);
    $pms_name = getPmsName();

    storeWebhookLogs(['id' => 0, 'partner_id' => 0, 'pms_name' => $pms_name, 'url' => $_SERVER['REQUEST_URI']], $pms_response, json_encode($data), '', 1, 1);

    if(empty($_REQUEST['token']) || empty($data)){
        sendLogToSlack('Octorate Webhook token or data missing', $data);
        apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);
        return;
    }

    $entity_type = config('db_config.partner_webhook_settings', 'type.booking');
    $_REQUEST['token'] = str_replace('?','',$_REQUEST['token']);
    $webhook_settings = getWebHookSettings(['pms_name' => $pms_name, 'pms_user_id' => 0, 'webhook_type' => $entity_type, 'credential_token' => base64_encode(trim($_REQUEST['token']))], true);


    if (!empty($webhook_settings)) {

        $data['content'] = $data['content'] ?? [];
        $booking = is_array($data['content']) ? $data['content']: json_decode($data['content'], true);

        $booking = map_pms_keys_to_partner_keys('reservation', $booking, $pms_name);

        $cax_response = new HotelReservation($booking);
        $cax_response->webhook_entity_type = $entity_type;
        $cax_response->pms_user_id = null;
        foreach ($webhook_settings as $webhook_setting) {
            sendWebHookToPartnerUser($webhook_setting, $pms_response, json_encode($cax_response));
        }
    }

    apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], CAX_SUCCESS_MESSAGE);

} catch (CaxException $caxException) {
    sendLogToSlack('Octorate Webhook Failed',
        [$caxException->getCode(), $caxException->getData(), $caxException->getMessage()]
    );

    apiResponse($caxException->getCode(), $caxException->getData(), $caxException->getMessage());
}