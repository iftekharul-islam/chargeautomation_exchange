<?php

namespace Core\System;

require_once __DIR__ . '/../../core/system/client/parser/keys_mapper.php';
require_once __DIR__ . '/../../core/system/client/parser/xml_parser.php';
require_once __DIR__ . '/../includes/autoload.php';
require_once __DIR__ . '/../const/pms_endpoints_const.php';
require_once __DIR__ . '/cax_validation_rule_keys.php';
require_once __DIR__ . '/../packages/http_validations/Validator.php';
require_once __DIR__ . '/../../core/includes/get_partner_and_partner_user_globally.php';
require_once __DIR__ . '/../../helpers/manifest_global_helper.php';

use Core\System\Client\Client;
use src\Validator;

trait PMS_Trait
{
    use PMS_ResponseHelper;

    /**
     * @var Client
     */
    private Client $client;
    private string $base_url = '';
    private array $headers;
    private string|null $pms_name = '';
    private string|null $pms_endpoint_file_path = '';

    public function _initiate_construct()
    {
        $this->pms_name = getPmsName();
        $this->client = new Client();
        $this->base_url = getApiBaseUrl();
        $this->headers = $this->setHeaders();
        $this->pms_endpoint_file_path = getPmsEndpointFilePath();
    }

    /**
     * Get response from pms and return after make it format Array
     * @param $request_name
     * @param $request_type
     * @param null $pattern_index
     * @return mixed
     * @throws \CaxException
     * @throws \JsonException
     */
    public function getFormattedResponse($request_name, $request_type, $pattern_index = null)
    {
        $this->setAuth();
        $endpoint_key = getManifestEndpointKey($request_name, $request_type);

        $request_data = $this->makeRequestData($endpoint_key, $pattern_index);

        $api = $this->requestUrl($endpoint_key, $request_data);

//        dd($api,$this->dataToSend($endpoint_key, $request_data));
        if ($this->pms_name == HOSPITABLE && $request_type == 'booking.list.read') {
            $api['url'] = str_replace('properties', 'properties[]', $api['url']);
        }
//        dd($this->dataToSend($endpoint_key, $request_data));
        $response = $this->client->sendRequest(
            $api['url'],
            $api['method'],
            $this->dataToSend($endpoint_key, $request_data)
        );

        return $this->formatResponseDataToArray($response, $endpoint_key);
    }


    /**
     * This function will deal with Content type of request data by configuration settings
     * @param $endpoint_key
     * @param null $request_data
     * @return array
     */
    public function dataToSend($endpoint_key, $request_data = null): array
    {
         $endpoint = config($this->pms_endpoint_file_path, $endpoint_key);

        $content_type = (($endpoint[REQUEST_METHOD_KEY] == POST || $endpoint[REQUEST_METHOD_KEY] == PUT) && !empty($endpoint[REQUEST_CONTENT_TYPE]))
            ? $endpoint[REQUEST_CONTENT_TYPE] :'';

        return match ($content_type) {
            REQUEST_CONTENT_TYPE_FORM_URL_ENCODE => [
                'headers' => array_merge($this->headers, ['Content-Type' => 'application/x-www-form-urlencoded']),
                'form_params' => $request_data
            ],

            REQUEST_CONTENT_TYPE_APPLICATION_JSON => [
                'headers' => array_merge($this->headers, ['Content-Type' => 'application/json']),
                'json' => $request_data
            ],

            default => ['headers' => $this->headers,  $request_data],
        };
    }

    /**
     * Set data format regarding to PMS before dispatching request to PMS after validate request parameters
     * @param string $pms_endpoint_file_index
     * @param $pattern_index
     * @return array|string
     * @throws \CaxException
     */
    private function makeRequestData($pms_endpoint_file_index = '', $pattern_index = null)
    {
        $endpoint_configuration = config($this->pms_endpoint_file_path, $pms_endpoint_file_index);

        $data = [];

       // dd($endpoint_configuration);
        $request_mapper_file = $endpoint_configuration[PMS_REQUEST_MAPPER_FILE];
        // Map, reflect default application request values onto specific indexes regarding to PMS configurations
        if (!empty($endpoint_configuration['extra_data'])) {
            $keys = array_keys($endpoint_configuration['extra_data']);
            $data = map_data($endpoint_configuration['extra_data'], array_combine($keys, $keys), false);
        }

        // Map, reflect user custom request values onto specific indexes regarding to PMS configurations
        $request_data = array_merge_recursive(
            $data,
            map_partner_keys_to_pms_keys(getPmsName(), $request_mapper_file, $pattern_index, $_REQUEST),
        );

        //validate http request
        if (!empty($endpoint_configuration[INPUT_VALIDATION_RULES])) {
            $this->validateHttpRequest($request_data, $endpoint_configuration, $pattern_index);
        }

        // Change Data format to XML, Json etc as per PMS request_type configurations
        switch (strtolower($endpoint_configuration['request_type'])) {
            case 'xml':
                // Format data to XML
                return "xmlRequest=" . json_to_xml(json_encode($request_data));
            default:
                return $request_data;
        }
    }

    /**
     * @param $request_data
     * @param $endpoint_configuration
     * @param null $pattern_index
     */
    private function validateHttpRequest($request_data, $endpoint_configuration, $pattern_index = null)
    {
        $request_parameters = config(getPmsRequestMapperFilePath($endpoint_configuration[PMS_REQUEST_MAPPER_FILE]), $pattern_index);

        foreach ($endpoint_configuration[INPUT_VALIDATION_RULES] as $input_field) {
            $validator = new Validator;

            //Set Rules as string e.g 'required|nullable' if is array of ['required', 'nullable']
            $rules = is_array($input_field[RULES]) ? implode('|', $input_field[RULES]) : $input_field[RULES];

            $validation = $validator->make($request_data,

                [$request_parameters[$input_field[INPUT_NAME]] => $rules],
                str_replace('{$input}', $input_field[INPUT_NAME], VALIDATION_MESSAGE)
            );

            $validation->validate();
            if ($validation->fails()) {
                $errors = $validation->errors();
                validationError($errors);
                break;
            }
            //$this->validateInputData($request_data, $request_parameters, $input_field);
        }
    }

    /**
     * Get request url from endpoints config regarding to request type index
     * @param string $pms_endpoint_file_index
     * @param array $request_data
     * @return array
     */
    private function requestUrl($pms_endpoint_file_index = '', $request_data = [])
    {
        $pms_endpoint = config($this->pms_endpoint_file_path, $pms_endpoint_file_index);
        $api = $this->base_url . $pms_endpoint[REQUEST_URL_KEY] ?? '';

        $content_type = $pms_endpoint[REQUEST_CONTENT_TYPE] ?? '';

        switch ($content_type) {
            case REQUEST_CONTENT_TYPE_FORM_URL_ENCODE:
                return ['url' => $api, 'method' => $pms_endpoint[REQUEST_METHOD_KEY] ?? 'GET'];

            default:
                $this->setRequestOffset($api);
                $this->setRequestExtras($api, $request_data);
                $this->reflectUrlParams($api, $request_data);
                return ['url' => $api, 'method' => $pms_endpoint[REQUEST_METHOD_KEY] ?? 'GET'];
        }
    }

    /**
     * Add limit & offset params into request url regarding to PMS params names
     * @param string $api
     * @param string $pms_limit_key
     * @param string $pms_offset_key
     * @param string $pms_page_key
     */
    public function setRequestOffset(&$api = '', $pms_limit_key = 'limit', $pms_offset_key = 'offset', $pms_page_key = 'page')
    {
        $paginate = [];

        if (!empty($_REQUEST[PAGE])) {
            $paginate[$pms_page_key] = $_REQUEST[PAGE];
        }

        $paginate[$pms_limit_key] = $paginate['size'] = !empty($_REQUEST['limit']) ? $_REQUEST['limit'] : 10;
        $paginate[$pms_offset_key] = !empty($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
        $paginate['per_page'] = !empty($_REQUEST['per_page']) ? $_REQUEST['per_page'] : $paginate[$pms_limit_key];

        $api .= !str_contains($api, '?') ? '?' : '&';
        $api .= http_build_query($paginate);
    }

    /**
     * @param string $api
     * @param array $extras
     */
    public function setRequestExtras(&$api = '', $extras = [])
    {
        if (!empty($extras)) {
            return;
        }

        $api .= !str_contains($api, '?') ? '?' : '&';
        $api .= http_build_query($extras);
    }

    /**
     * Reflect dynamic url params values from request data.
     * @param $url
     * @param $request_data
     */
    private function reflectUrlParams(&$url, $request_data)
    {
        foreach ($request_data as $key => $value) {
            $url = str_replace(('{' . $key . '}'), $value, $url);
        };

        $url .= '&'.http_build_query($request_data);
    }

    /**
     * @param $data
     * @param $pms_endpoint_file_index
     * @return mixed
     * @throws \JsonException
     */
    private function formatResponseDataToArray($data, $pms_endpoint_file_index)
    {
        $endpoint_configuration = config($this->pms_endpoint_file_path, $pms_endpoint_file_index);

        // Change Data format to XML, Json etc as per PMS response_type configurations
        switch (strtolower($endpoint_configuration['response_type'])) {
            case 'xml':
                // Format XML data to Array
                return json_decode(xml_to_json($data), true);
            default:
                return is_string($data) ? json_decode($data, true) : $data;
        }
    }

    /**
     * $webhook_type => booking, guest, property etc
     * @param $webhook_type
     * @return string
     */
    private function getWebhookURL($webhook_type)
    {
        return $_ENV['APP_URL'] . '/' . getPMSManifest()['webhooks'][$webhook_type]['paths']['webhook_receiver_file'] . '?token=' . getUserCredentialToken();
    }

    //TODO::we are not using these following two functions currently
    private function validateInputData($request_data, $request_parameters, $input_field)
    {
        /*foreach ($input_field[RULES] as $rule => $value) {
            $run_validation_rule = $this->runValidationRule($request_data, $request_parameters, $input_field, $rule, $value);
            if ($run_validation_rule['flag'] === false) {
                throwException($run_validation_rule['message'], CAX_VALIDATION_ERROR);
                break;
            }
        }*/
    }

    private function runValidationRule($request_data, $request_parameters, $input_field, $rule, $value = null)
    {

        //$input_name = $request_parameters[$input_field[INPUT_NAME]];

        /*switch ($rule) {
            case NOT_EMPTY :
                $flag = (array_key_exists($input_name, $request_data) && !empty($request_data[$input_name]));
                $case = NOT_EMPTY;
                break;
            case SHOULD_NUMERIC :
                $flag = (array_key_exists($input_name, $request_data) && is_numeric($request_data[$input_name]));
                $case = SHOULD_NUMERIC;
                break;
            case NOT_SPECIAL_CHARACTERS :
                $flag =  (array_key_exists($input_name, $request_data) && preg_match("/^[a-zA-Z0-9_' ]+$/", $request_data[$input_name]));
                $case = NOT_SPECIAL_CHARACTERS;
                break;
            case IN_ARRAY :
                $flag = (array_key_exists($input_name, $request_data) && in_array($request_data[$input_name], array_values($value['allowed_values'])));
                $case = IN_ARRAY;
                break;
            default:
                $flag = true;
                $case = DEFAULT_MESSAGE;
                break;
        }*/

        //return ['flag' => $flag, 'message' => $value['message'] ?? str_replace('{$input}', $input_field[INPUT_NAME], VALIDATION_MESSAGE[$case])];
    }

    public static function getOAuthCallBackUrl()
    {
        $app = isLiveApp() ? 'production' : 'stage';
        return getPMSManifest()['user_onboard']['OAuth1'][$app]['call_back_url'] ?? '';
    }

    public static function getOAuthUrl()
    {
        $app = isLiveApp() ? 'production' : 'stage';
        return getPMSManifest()['user_onboard']['OAuth1'][$app]['url'] ?? '';
    }

    public static function getOAuthRedirectUrl()
    {
        return getPMSManifest()['user_onboard']['OAuth1']['redirect_uri'] ?? '';
    }

}