<?php

require_once __DIR__ . '/../core/DB.php';
require_once __DIR__ . '/../core/const/pms_info_const.php';
require_once __DIR__ . '/../core/const/booking_status_const.php';

use Core\System\Client\Client;

if (!function_exists('toArray')) {
    /**
     * Check Data type, convert data to key values array
     * @param $data
     * @return array|mixed
     */
    function toArray($data): array
    {
        if (!empty($data) && is_string($data)) {

            return json_decode($data, true);
        } else {

            return !empty($data) ? json_decode(json_encode($data), true) : [];
        }
    }
}

if (!function_exists('env')) {
    /**
     *
     * @param string $var_name
     * @param $default
     * @return mixed
     */
    function env(string $var_name, $default = null)
    {
        return $_ENV[$var_name] ?? $default;
    }
}

if (!function_exists('config')) {

    /**
     * @param $path
     * @param null $key
     * @param null $default
     * @return array |string |null
     * Example usage:
     * config('pms.opera.to_partner', 'opera.label')
     * set file path folder separated by "." notation and key as 2nd parameter.
     * If key set as null the whole file's content will be returned in response
     *
     */
    function config($path, $key = null, $default = null)
    {
        //TODO::Cache Response
        $config = null;
        $path = __DIR__ . '/../core/config/' . str_replace('.', '/', $path) . '.php';

        if (file_exists($path)) {
            $config = @include($path);
        }

        if (empty($config) || empty($key)) {
            return is_array($config) ? $config : $default;
        }

        $nested_keys = explode('.', $key);

        foreach ($nested_keys as $key) {
            if (!isset($config[$key])) {
                $config = null;
                break;
            }
            $config = $config[$key];
        }

        return $config ?? $default;
    }
}

if (!function_exists('dd')) {
    function dd()
    {
        $values = [];
        $args_count = count(func_get_args());
        foreach (func_get_args() as $key => $x) {
            $i = ($key + 1);
            $value = isJson($x) ? json_decode($x) : $x;
            if ($args_count > 1) {
                $values[$i] = $value;
            } else {
                $values['dump'] = $value;
            }
        }

        $caller = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];
        $callerFile = $caller['file'];
        $callerLine = $caller['line'];
        $callerFunction = $caller['function'];
        // Log the caller's information
        $values['__location']= isLiveApp() ? 'Debug=false':  "Function:$callerFunction File:$callerFile Line:$callerLine";

        header('Content-Type: application/json; charset=utf-8');
        die(json_encode($values));
    }
}

if (!function_exists('response')) {
    /**
     *
     * @param null $data
     */
    function response($data = null)
    {
    }
}

if (!function_exists('generateUuId')) {
    /**
     * @param $table
     * @param $column
     * @return string
     * @throws CaxException
     */
    function generateUuId($table, $column)
    {
        try {

            $uu_id = uniqid();
            $encoded_uu_id = base64_encode($uu_id);


            if (DB::executeStatement("SELECT id FROM $table WHERE $column = '$encoded_uu_id'")->rowCount() == 0) {
                return $uu_id;
            } else {
                return generateUuId($table, $column); // add a return statement here
            }

        } catch (Exception $exception) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_INTERNAL_SERVER_ERROR], CAX_INTERNAL_SERVER_ERROR);
        }
    }
}

if (!function_exists('arrayFlatten')) {
    function arrayFlatten($array = null, $depth = 1)
    {
        $result = [];
        if (!is_array($array)) $array = func_get_args();
        foreach ($array as $key => $value) {
            if (is_array($value) && $depth) {
                $result = array_merge($result, arrayFlatten($value, $depth - 1));
            } else {
                $result = array_merge($result, [$key => $value]);
            }
        }
        return $result;
    }
}

if (!function_exists('isJson')) {
    function isJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }

        $json = json_decode($string);
        return $json !== null && json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('saveQueryLog')) {
    function saveQueryLog($statement, $execute_parameters = [])
    {
        $result = getModelAndAction($statement);

        if ($result['action'] == 'select') {
            return;
        }

        DB::executeQueryForLog('INSERT INTO `query_logs` (`model`, `action`, `status`, `statement`, `statement_value`) VALUES (:model, :action, :status, :statement, :statement_value)',
            ['model' => $result['model'], 'action' => $result['action'], 'status' => 'success', 'statement' => $statement, 'statement_value' => json_encode($execute_parameters)]
        );
        return true;
    }
}

if (!function_exists('saveHttpLog')) {
    function saveHttpLog($response)
    {
        $partner_id = $partner_user_id = null;
        if (function_exists('getPartnerId')) {
            $partner_id = getPartnerId();
        }
        if (function_exists('getPartnerUserId')) {
            $partner_user_id = getPartnerUserId();
        }

        $request_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"], '?');
        $request_url = $request_url ?: '';
        $request_data = !empty($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'';

        $response_code = $response['status_code'];
        $response_data = json_encode($response);
        DB::executeQueryForLog('INSERT INTO `http_logs` (`request_url`, `request_data`, `response_data`, `response_code`, `partner_id`, `partner_user_id`) VALUES (:request_url, :request_data, :response_data, :response_code, :partner_id, :partner_user_id)',
            ['request_url' => $request_url, 'request_data' => $request_data, 'response_data' => $response_data, 'response_code' => $response_code, 'partner_id' => $partner_id, 'partner_user_id' => $partner_user_id]
        );
        return true;
    }
}

if (!function_exists('saveExceptionLog')) {
    function saveExceptionLog()
    {
        $partner_id = getPartnerId();
        $partner_user_id = getPartnerUserId();
        echo $partner_id;
        echo '-';
        echo $partner_user_id;
    }
}

if (!function_exists('throwException')) {
    function throwException($message = "", $code = 0, Throwable $previous = null, $data = [])
    {
        throw new CaxException($message, $code, $previous, $data);
    }
}

if (!function_exists('getModelAndAction')) {
    function getModelAndAction($query)
    {
        $query = str_replace("  ", " ", strtolower($query));
        $action = strtok($query, " ");

        switch ($action) {
            case "select":
                $model = '';
                break;

            case "delete":
                $model = trim($query, 'delete from ');
                break;
            case "insert":
                $model = trim($query, 'insert into ');
                break;
            default:
                $model = trim($query, 'update ');
        }
        $model = str_replace("`", "", strtok($model, " "));
        return ['action' => $action, 'model' => $model];
    }
}

if (!function_exists('apiResponse')) {
    function apiResponse($code = CAX_SUCCESS_RESPONSE_CODE, $data = null, $message = CAX_SUCCESS_MESSAGE, $additional = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        $response = [
            'status' => ($code==CAX_SUCCESS_RESPONSE_CODE),
            'status_code' => $code,
            'message' => $message,
            'data' => $data,
            'additional' => $additional,
        ];
        echo json_encode($response);
        saveHttpLog($response);
    }
}

if (!function_exists('sendLogToSlack')) {
    function sendLogToSlack(string $message, $data = [])
    {
        try {
            // Instantiate with defaults, so all messages created
            if(isset($_ENV['LOG_SLACK_WEBHOOK_URL']) && !empty($_ENV['LOG_SLACK_WEBHOOK_URL'])){
                $client = new Maknz\Slack\Client($_ENV['LOG_SLACK_WEBHOOK_URL']);
                $log = json_encode(['message' => $message, 'data' => $data]);
                $client->send($log);
            }
        } catch (\Exception $e) {
            //TODO::
        }
    }
}

if (!function_exists('isValidApiKey')) {
    /**
     * @param $partner_id
     * @param $api_key
     * @return bool
     * @throws CaxException
     */
    function isValidApiKey($partner_id, $api_key)
    {
        if (empty($partner_id) || empty($api_key)) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_PARTNER_UNAUTHORIZED_ERROR], CAX_PARTNER_UNAUTHORIZED_ERROR);
            return false;
        }
        return true;
    }
}

if (!function_exists('isValidCredentialToken')) {
    /**
     * @param $partner_user_id
     * @param $credential_token
     * @return bool
     * @throws CaxException
     */
    function isValidCredentialToken($partner_user_id, $credential_token)
    {
        if (empty($partner_user_id) || empty($credential_token)) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_INVALID_CREDENTIAL_TOKEN_ERROR], CAX_INVALID_CREDENTIAL_TOKEN_ERROR);
            return false;
        }
        return true;
    }
}

if (!function_exists('validationError')) {
    function validationError($errors)
    {
        foreach (array_slice($errors->firstOfAll(), 0, 1, true) as $key => $value) ;
        throwException($value, CAX_VALIDATION_ERROR);
    }
}

if (!function_exists('setBookingSource')) {
    function setBookingSource(&$data, $value_to_map)
    {
        $booking_sources = config('pms.'.getPmsName().'.booking_sources');

        if(empty($booking_sources[$value_to_map])) {
            sendLogToSlack("$value_to_map  booking source is not available in cax ".getPmsName());
        }

        $data['BookingChannel'] = $booking_sources[$value_to_map] ?? $value_to_map;
    }
}

if(!function_exists('getPmsList')){
    function getPmsList($requested_pms = null){
        $data = [];
        if(!empty($requested_pms) && !file_exists(__DIR__ . '/../core/config/pms/' . $requested_pms) ){
            return ['data' => '', 'message' => 'We could not find the PMS. Please make an API call to list_pms (without pms) endpoint to see the list of all available PMSs.'];
        }

        $manifest_files_contents = getManifestFilesContents($requested_pms);
        if(!empty($manifest_files_contents)) {
            foreach ($manifest_files_contents as $manifest) {
                if($manifest->integration_completed && $manifest->enabled_for_partners){
                    $data[] = [
                        'Label' => $manifest->display_name,
                        'Pms Url' => $manifest->url,
                        'Description' => $manifest->description,
                        'Name' => $manifest->name,
                        'Credentials' => $manifest->user_onboard->credentials,
                        'Pms Documentation Url' => $manifest->api_docs,
                        'OAuth Redirection' => str_contains($manifest->user_onboard->type, 'OAuth'),
                        "Available Apis" => unsetKey($manifest->requests, 'paths'),
                        "Available Webhooks" => unsetKey($manifest->webhooks, 'paths'),
                    ];
                }
            }
        }
        return ['data' => $data, 'message' => CAX_SUCCESS_MESSAGE_SUPPORTED_PMS_LIST];
    }
}

if(!function_exists('getManifestFilesContents')){
    function getManifestFilesContents($requested_pms = null){
        $data = [];
        $dir = __DIR__ . '/../core/config/pms/';

        $pms_list = !empty($requested_pms) ? [$requested_pms] : scandir($dir);
        $pms_list = array_diff($pms_list, array('.', '..'));

        foreach ($pms_list as $pms_name) {
            if (is_dir($dir.'/'.$pms_name) && !in_array($pms_name, array('.', '..')) && substr($pms_name, 0, 1) !== '.' && !empty($pms_name)) {
                if (!file_exists($dir.'/'.$pms_name.'/manifest.json')) {
                    sendLogToSlack('Missing manifest.json file', ['PMS' => $pms_name]);
                    continue;
                }
                else {
                    $manifest_file_json_data = file_get_contents($dir.'/'.$pms_name.'/manifest.json');
                    $data[] =  json_decode($manifest_file_json_data);
                }
            }
        }

        return $data;
    }
}

if (!function_exists('setBookingStatus')) {
    function setBookingStatus(&$data, $value_to_map)
    {
        if(!empty($data['ResStatus']) && $data['ResStatus'] === BLOCKED) {
            return; //Booking status already set as Blocked
        }

        $booking_statuses = config('pms.'.getPmsName().'.booking_status');

        if(empty($booking_statuses[$value_to_map])) {
            sendLogToSlack("$value_to_map  booking status is not available in cax ".getPmsName());
        }

        $data['ResStatus'] = $booking_statuses[$value_to_map] ?? $value_to_map;
    }
}

if (!function_exists('getWebHookSettings')) {
    function getWebHookSettings(array $conditions, $skip_pms_user_id_check=false)
    {
        $query = 'SELECT `pu`.`id`, `pu`.`partner_id`, `pu`.`pms_name`, `pws`.`type`, `pws`.`url` 
            FROM `partner_users` AS `pu` 
            INNER JOIN `partner_webhook_settings` AS `pws` 
            ON `pu`.`id`=`pws`.`partner_user_id` 
            WHERE `pu`.`pms_name`=:pms_name 
            AND `pws`.`type`=:webhook_type';

        $query .= $skip_pms_user_id_check ? '' : ' AND `pu`.`pms_user_id`=:pms_user_id';
        $query .= !empty($conditions['credential_token']) ? ' AND `pu`.`credential_token`=:credential_token' :'';

        if ($skip_pms_user_id_check) {
            unset($conditions['pms_user_id']);
        }


        $get_webhook_settings = DB::executeStatement($query, $conditions);
        return ($get_webhook_settings->rowCount() > 0) ? $get_webhook_settings->fetchAll(PDO::FETCH_ASSOC) : [];
    }
}

if (!function_exists('sendWebHookToPartnerUser')) {
    function sendWebHookToPartnerUser($webhook_setting, $pms_response, $cax_encoded_response)
    {
        try {
            $url = $webhook_setting['url'];
            $client = new Client();
            $partner_user_response = $client->sendRequest($url, 'post', ['json' => json_decode($cax_encoded_response, true)]);
            $partner_user_response_array = json_decode($partner_user_response, true);//TODO get response form client
            $status = config('db_config.webhook_logs', 'status.success');
            if (!empty($partner_user_response_array) && $partner_user_response_array['code'] != CAX_SUCCESS_RESPONSE_CODE) {
                storeWebhookAttempt($webhook_setting, $pms_response, $cax_encoded_response, 0);
                $status = config('db_config.webhook_logs', 'status.reattempt');
            }
            storeWebhookLogs($webhook_setting, $pms_response, $cax_encoded_response, $partner_user_response, $status, 1);
        } catch (Exception $exception) {
            storeWebhookAttempt($webhook_setting, $pms_response, $cax_encoded_response, 0);
            //sendLogToSlack($exception->getMessage());
        }
    }
}

if(!function_exists('unsetKey')){
    function unsetKey($data, $key){
        foreach ($data as $available){
            unset($available->$key);
        }

        return $data;

    }
}

if(!function_exists('isLiveApp')){
    function isLiveApp(){
        return $_ENV['APP_ENV'] != 'development' || !$_ENV['APP_DEBUG'] || $_ENV['APP_URL'] == 'https://cax.chargeautomation.com';
    }
}