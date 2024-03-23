<?php

use Core\System\Client\Client;

require_once __DIR__ . '/../../core/includes/autoload.php';

$state = $_REQUEST['state'] ?? '';
$code = $_REQUEST['code'] ?? '';
$slug = explode('__', $state);

try {


    if (!empty($_REQUEST['error'])) {
        redirect_response_header(($slug[2] ?? ''), false, $_REQUEST['error_description']);
        exit();
    }

    $api = $_ENV['OWNER_REZ_OAUTH_URL'] . "/oauth/access_token";

    $data = [

        'headers' => [
            'Authorization' => 'Basic ' . base64_encode(($_ENV['OWNER_REZ_CLIENT_ID'] . ':' . $_ENV['OWNER_REZ_CLIENT_SECRET'])),
            'Content-Type' => 'application/x-www-form-urlencoded'
        ],

        'form_params' => ['grant_type' => 'authorization_code', 'code' => $code]
    ];

    $client = new Client();
    $response = $client->sendRequest($api, 'POST', $data);
    $response = json_decode($response, true);



    $query = DB::executeStatement("SELECT id,credentials, credential_token FROM `partner_users` WHERE id = :id", ['id' => $slug[0]]);
    $result = $query->fetch(\PDO::FETCH_ASSOC);


    if (empty($response['access_token']) || empty($response) || count($slug) < 3 || empty($result['id'])
        || hash_hmac('sha256', $result['id'], $result['credential_token'], false) !== $slug[1]) {
        apiResponse(CAX_ERROR_RESPONSE_CODE, null, 'Request forgery.');
        exit();
    }

    $response = array_merge(json_decode($result['credentials'], true), $response);

    DB::executeStatement(
        'UPDATE `partner_users` SET credentials=:credentials, pms_user_id=:pms_user_id WHERE id=:id',
        ['id' => $result['id'], 'credentials' => json_encode($response),'pms_user_id' => $response['user_id']]
    );

    updateOldOnboardings($response);

    redirect_response_header($slug[2], true, 'success');

} catch (Exception $caxException) {
    redirect_response_header($slug[2], false, $caxException->getMessage());
}


function updateOldOnboardings($response = [])
{
    if (!empty($response['user_id'])) {

        $user_id = '%"user_id":' . $response['user_id'] . ',%';
        $user_display_name = '%"user_display_name":"'.$response['user_display_name'].'"%';
        $pms_name = OWNER_REZ;

        DB::executeStatement(
            "UPDATE `partner_users` SET credentials=:credentials WHERE  credentials like '$user_id' and  
                                                          credentials like '$user_display_name' and pms_name='$pms_name'",
            ['credentials' => json_encode($response)]
        );
    }
}

function redirect_response_header($hostname, $status, $message)
{

    if (!empty($hostname)) {
        echo '<form id="redirect-form" action="' . base64_decode($hostname) . '" method="get">
          <input type="hidden" name="status" value="' . ($status ?: 0) . '">
          <input type="hidden" name="message" value="' . $message . '">
          <input type="submit" style="display: none" value="Submit">
        </form>';
        echo "<script>document.getElementById('redirect-form').submit();</script>";
        exit();
    }

    $status ? apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], $message) : apiResponse(CAX_ERROR_RESPONSE_CODE, [], $message);

}
