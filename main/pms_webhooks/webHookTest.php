<?php
/*
require_once __DIR__ . '/../../helpers/webhook_helper.php';

$partner_user = ['id'=>0,'partner_id'=>0,'pms_name'=>'owner_rez','url'=>''];
$pms_response = '{"entity_id":"321086","entity_type":"booking","action":"create","user_id":347317190}';
//$cax_response = json_encode($_REQUEST['data']);
//$cax_response = json_encode($_REQUEST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request data
    $cax_response = json_decode(file_get_contents('php://input'), true);

    // Return a response
    http_response_code(200);
    $response = [
        'status' => true,
        'code' => 200,
        'message' => 'Success',
        'data' => [],
        'additional' => '',
    ];
    echo json_encode($response);
} else {
    $cax_response = [];

    http_response_code(405);
    $response = [
        'status' => false,
        'code' => 405,
        'message' => 'Error',
        'data' => [],
        'additional' => '',
    ];
    echo json_encode($response);
}
storeWebhookLogs($partner_user, $pms_response,json_encode($cax_response), 'This is partner user response', '10', '1');*/
?>