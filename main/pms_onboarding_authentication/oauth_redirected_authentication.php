<?php

require_once __DIR__ . '/../../core/includes/autoload.php';
require_once __DIR__ . '/../../core/includes/get_partner_and_partner_user_globally.php';

$state = $_REQUEST['state'] ?? '';
$code = $_REQUEST['code'] ?? '';
$slug = explode('__', $state);

try {

    //  print_r([$slug[1]]);

    if (!empty($_REQUEST['error'])) {
        redirect_response_header(($slug[2] ?? ''), false, $_REQUEST['error_description']);
        exit();

    } elseif (count($slug) < 4) {
        redirect_response_header(($slug[2] ?? ''), false, 'Request forgery.');
        exit();
    }

    setPmsName($slug[3]);

    /**
     * @var $response array
     * @var $pms \Core\System\pms\octorate\PMS|\Core\System\pms\owner_rez\PMS
     */
    $pms_path = "\Core\System\pms\\" . $slug[3] . "\PMS";
    $pms = new $pms_path();
    $response = $pms->authenticateAccessCode($code);

    $query = DB::executeStatement("SELECT id,credentials, credential_token FROM `partner_users` WHERE id = :id", ['id' => $slug[0]]);
    $result = $query->fetch(\PDO::FETCH_ASSOC);

    if (empty($response) || empty($response['access_token']) || empty($result['id'])
        || (hash_hmac('sha256', $result['id'], $result['credential_token'], false) != $slug[1])) {

        /*dd(json_encode([
            'Forgery',
            $slug,
            $response,
            $result,
            'o' => (hash_hmac('sha256', $result['id'], $result['credential_token'], false)),
            'ac' => empty($response['access_token']),
            'r' => $result['id']
        ]));*/


        apiResponse(CAX_ERROR_RESPONSE_CODE, null, 'Request forgery.');
        exit();
    }

    $response = array_merge(json_decode($result['credentials'], true), $response);
    DB::executeStatement(
        'UPDATE `partner_users` SET credentials=:credentials, pms_user_id=:pms_user_id WHERE id=:id',
        ['id' => $result['id'], 'credentials' => json_encode($response), 'pms_user_id' => ($response['user_id'] ?? 0)]
    );

    // updateOldOnboardings($response); //TODO::handle

    redirect_response_header($slug[2], true, 'success');

} catch (Exception $caxException) {
    redirect_response_header($slug[2], false, $caxException->getMessage());
}


function updateOldOnboardings($response = [])
{
    if (!empty($response['user_id'])) {

        $user_id = '%"user_id":' . $response['user_id'] . ',%';
        $user_display_name = '%"user_display_name":"' . $response['user_display_name'] . '"%';
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

    $status ? apiResponse(CAX_SUCCESS_RESPONSE_CODE, [], $message) : apiResponse(CAX_CLIENT_UNAUTHORIZED_ERROR, [], $message);

}
