<?php

namespace Core\System\pms\octorate;

use Core\System\PMS_Interface;
use Core\System\PMS_Trait;
use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\HotelReservation\Guest\Guest;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;
use DB;

require_once __DIR__ . '/../../../const/pms_endpoints_const.php';

class  PMS implements PMS_Interface
{
    use PMS_Trait, PMS_Helper;

    private array $webhook_types = [
        'RESERVATION_CREATED',
        'RESERVATION_CHANGE',
        'RESERVATION_CANCELLED',
        'RESERVATION_CONFIRMED',
    ];

    /**
     * PMS constructor.
     * @param bool $set_auth
     * @throws \CaxException
     */
    public function __construct($set_auth=true)
    {
        $this->_initiate_construct();
        //$this->setAuth();
    }

    /**
     * @return HotelReservation
     * @throws \CaxException
     */
    public function get_booking()
    {
        try {

            $formatted_response = $this->getFormattedResponse('booking', 'booking.single.read');
            $reservation = !empty($formatted_response['id']) ? [$formatted_response] : [];
            return $this->makeCaxReservationInstances($reservation)[0] ?? null;

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return HotelReservation[]
     * @throws \CaxException
     */
    public function get_booking_list()
    {
        try {
            $formatted_response = $this->getFormattedResponse('booking', 'booking.list.read');
            return $this->makeCaxReservationInstances($formatted_response['data'] ?? []);
        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return [];
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return Hotel
     * @throws \CaxException
     */
    public function get_property()
    {
        try {

            $formatted_response = $this->getFormattedResponse('property', 'property.single.read', 'property_single');
            $hotel = $formatted_response ? [$formatted_response] : [];
            return $this->makeCaxHotelInstances($hotel)[0] ?? null;

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return Hotel[]
     * @throws \CaxException
     */
    public function get_property_list()
    {
        try {
            $formatted_response = $this->getFormattedResponse('property', 'property.list.read', 'property_list');
            return $this->makeCaxHotelInstances(($formatted_response ?? []));

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return [];
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return Guest
     * @throws \CaxException
     */
    public function get_guest()
    {
        // TODO: Implement get_guest() method.
    }


    public function update_booking()
    {
        // TODO: Implement update_booking() method.
    }

    /**
     * @param $type
     * @return true|void
     * @throws \CaxException
     */
    public function add_webhook($type)
    {
        try {
            $this->setAuth();

            if ($type != config('db_config.partner_webhook_settings', 'type.booking')) {
                return true;
            }

            if (!isLiveApp()) { //Remove Old dummy webhooks
                $this->delete_webhook(config('db_config.partner_webhook_settings', 'type.booking'));
            }

            $pms_webhooks = $this->list_webhooks();

            $webhook_url = $this->getWebhookURL(config('db_config.partner_webhook_settings', 'type.booking'));

            $headers = $this->headers;
            $headers['content-type'] = 'application/x-www-form-urlencoded';
            foreach ($this->webhook_types as $webhook_type) {
                if (empty($this->filterPMSEnabledWebhook($pms_webhooks, $webhook_type, $webhook_url))) {
                    $this->client->sendRequest($this->base_url . '/subscription/'.$webhook_type, 'POST',
                        [
                            'headers' => $headers,
                            'form_params' => ['url' => $webhook_url, 'type' => $webhook_type]
                        ]
                    );
                }
            }

            return true;

        } catch (\Exception $exception) {
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param $type
     * @return void
     */
    public function update_webhook($type)
    {
        $this->add_webhook($type);
    }

    /**
     * @param $type
     * @return true|void
     * @throws \CaxException
     */
    public function delete_webhook($type)
    {
        try {
            if ($type != config('db_config.partner_webhook_settings', 'type.booking')) {
                return true;
            }

            $this->setAuth();
            $pms_webhooks = $this->list_webhooks();
            $webhook_url = $this->getWebhookURL(config('db_config.partner_webhook_settings', 'type.booking'));

            foreach ($this->webhook_types as $webhook_type) {

                $pms_webhook = $this->filterPMSEnabledWebhook($pms_webhooks, $webhook_type, $webhook_url, !isLiveApp());

                if (!empty($pms_webhook['id'])) {
                    $this->client->sendRequest(($this->base_url . '/subscription/' . $pms_webhook['id']), 'DELETE ',
                        [
                            'headers' => $this->headers,
                        ]
                    );
                }
            }

            return true;

        } catch (\Exception $exception) {
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return array|mixed
     * @throws \CaxException
     */
    private function list_webhooks()
    {
        $this->setAuth();
        $response = $this->client->sendRequest($this->base_url . '/subscription', 'GET', ['headers' => $this->headers]);
        $response = json_decode($response, true);

        return !empty($response[0]['id']) ? $response : [];
    }

    /**
     * @return mixed
     */
    public function get_child_property_list()
    {
        return [];
    }


    /**
     * @throws \CaxException
     */
    public function make_auth()
    {
        $api = $this->base_url . '/identity/refresh';
        $credentials = getUserCredentials();
        $data = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'client_id' => $_ENV['OCTORATE_CLIENT_ID'],
                'client_secret' => $_ENV['OCTORATE_CLIENT_SECRET'],
                'refresh_token' => $credentials['refresh_token'],
            ]
        ];

        $response = json_decode($this->client->sendRequest($api, 'POST', $data), true);

        // Update Access_token (DB & global vars)
        if (!empty($response['access_token'])) {
            $response = array_merge(getUserCredentials(), $response);
            setUserCredentials($response);//Update Global values
            DB::executeStatement(
                'UPDATE `partner_users` SET credentials=:credentials WHERE id=:id',
                ['id' => getPartnerUserId(), 'credentials' => json_encode($response)]
            );
        }
    }

    /**
     * @return string
     */
    public static function oauth_url()
    {
        $url = self::getOAuthUrl();
        $url .= '?client_id=' . $_ENV['OCTORATE_CLIENT_ID'];
        $url .= '&redirect_uri=' . $_ENV['APP_URL'] . self::getOAuthRedirectUrl();

        return $url;
    }

    /**
     * @param $code
     * @return false|string
     * @throws \Exception
     */
    public function authenticateAccessCode($code)
    {

        $api = self::getOAuthCallBackUrl();

        $data = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'code' => $code,
                'grant_type' => 'code',
                'client_id' => $_ENV['OCTORATE_CLIENT_ID'],
                'client_secret' => $_ENV['OCTORATE_CLIENT_SECRET'],
                'redirect_uri' => $_ENV['APP_URL'] . '/main/pms_onboarding_authentication/oauth_redirected_authentication',
//                'redirect_uri' => 'https://cax-staging.chargeautomation.com/main/pms_onboarding_authentication/oauth_redirected_authentication',
            ]
        ];


        return json_decode($this->client->sendRequest($api, 'POST', $data), true);

    }


    /**
     * @return mixed|null
     * @throws \CaxException
     */
    public function get_unit()
    {
        try {

            $formatted_response = $this->getFormattedResponse('unit', 'unit.single.read');
            $units = $formatted_response ? [$formatted_response] : [];
            return $this->makeCaxUnitInstances($units)[0] ?? null;

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return array|mixed|null
     * @throws \CaxException
     */
    public function get_unit_list()
    {
        try {

            $formatted_response = $this->getFormattedResponse('unit', 'unit.list.read');
            $units = $formatted_response ? $formatted_response : [];
            return $this->makeCaxUnitInstances($units) ?? null;

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return [];
            }

            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}

?>