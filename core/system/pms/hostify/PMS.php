<?php

namespace Core\System\pms\hostify;

use Core\System\PMS_Interface;
use Core\System\PMS_Trait;
use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\HotelReservation\Guest\Guest;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;

require_once __DIR__ . '/../../../const/pms_endpoints_const.php';

class  PMS implements PMS_Interface
{
    use PMS_Trait, PMS_Helper;

    private array $webhook_types = ['move_reservation', 'new_reservation', 'update_reservation'];

    public function __construct()
    {
        $this->_initiate_construct();
        $this->setAuth();
    }

    /**
     * @return HotelReservation
     * @throws \CaxException
     */
    public function get_booking()
    {
        try {
            $formatted_response = $this->getFormattedResponse('booking', 'booking.single.read');
            $reservation = !empty($formatted_response['reservation']) ? [$formatted_response['reservation']] : [];
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
            return $this->makeCaxReservationInstances($formatted_response['reservations'] ?? []);

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
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
            $hotels = !empty($formatted_response['listing']) ?
                [
                    array_merge(
                        $formatted_response['listing'], ['rooms' => $formatted_response['rooms']]
                    )
                ] : [];
            return $this->makeCaxHotelInstances($hotels)[0] ?? null;

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return array|void
     * @throws \CaxException
     */
    public function get_property_list()
    {
        try {
            $formatted_response = $this->getFormattedResponse('property', 'property.list.read');
            return $this->makeCaxHotelInstances(($formatted_response['listings'] ?? []));

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
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
        try {
            $formatted_response = $this->getFormattedResponse('guest', 'guest.single.read');
            if (!empty($formatted_response['guest'])) {
                return new Guest(map_pms_keys_to_partner_keys('guest', $formatted_response['guest']));
            }

        } catch (\Exception $exception) {
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return null;
    }

    /**
     * @throws \CaxException
     */
    public function make_auth()
    {
        try {
            $response = $this->client->sendRequest($this->base_url . 'companies', 'GET', ['headers' => $this->headers]);
            $response = json_decode($response, true);

            if (empty($response['success']) || (isset($response['status_code']) && $response['status_code'] == 401)) {
                throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
            }

        } catch (\Exception $exception) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR].'Client authentication failed.', CAX_CLIENT_UNAUTHORIZED_ERROR, $exception);
        }

    }

    /**
     * @throws \CaxException
     */
    public function update_booking()
    {
        throwException(CAX_EXCEPTION_MESSAGES[CAX_REQUEST_NOT_SUPPORTED], CAX_REQUEST_NOT_SUPPORTED);
    }


    /**
     * @return array
     * @throws \CaxException
     */
    private function list_webhooks()
    {
        $response = $this->client->sendRequest($this->base_url . 'webhooks', 'GET', ['headers' => $this->headers]);
        $response = json_decode($response, true);

        if (empty($response['success'])) {
            throwException('Fail to list webhooks from PMS', CAX_INTERNAL_SERVER_ERROR);
        }

        return $response['webhooks']??[];
    }

    /**
     * @param $type
     * @return bool
     * @throws \CaxException
     */
    public function add_webhook($type)
    {
        try {
            if ($type != config('db_config.partner_webhook_settings', 'type.booking')) {
                return true;
            }

            $pms_webhooks = $this->list_webhooks();
            $webhook_url = $this->getWebhookURL(config('db_config.partner_webhook_settings', 'type.booking'));

            foreach ($this->webhook_types as $webhook_type) {
                if (empty($this->filterPMSEnabledWebhook($pms_webhooks, $webhook_type, $webhook_url))) {
                    $this->client->sendRequest($this->base_url . 'webhooks', 'POST',
                        [
                            'headers' => $this->headers,
                            'json' => ['notification_type' => $webhook_type, 'url' => $webhook_url]
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
     * @throws \CaxException
     */
    public function update_webhook($type)
    {
        $this->add_webhook($type);
    }

    /**
     * @param $type
     * @return bool
     * @throws \CaxException
     */
    public function delete_webhook($type)
    {
        try {
            if ($type != config('db_config.partner_webhook_settings', 'type.booking')) {
                return true;
            }

            $pms_webhooks = $this->list_webhooks();
            $webhook_url = $this->getWebhookURL(config('db_config.partner_webhook_settings', 'type.booking'));

            foreach ($this->webhook_types as $webhook_type) {

                $pms_webhook = $this->filterPMSEnabledWebhook($pms_webhooks, $webhook_type, $webhook_url);

                if (!empty($pms_webhook['id'])) {
                    $this->client->sendRequest(($this->base_url . 'webhooks/'.$pms_webhook['id']), 'DELETE ',
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
     * @return array|void
     * @throws \CaxException
     */
    public function get_child_property_list()
    {
        try {
            $formatted_response = $this->getFormattedResponse('child_property', 'child_property.list.read', 'child_property_list');
            return $this->makeCaxHotelInstances(($formatted_response['listings'] ?? []));

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return [];
            }

            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }


    /**
     * @return mixed
     */
    public function get_unit()
    {
        // TODO: Implement get_unit() method.
    }

    /**
     * @return mixed
     */
    public function get_unit_list()
    {
        // TODO: Implement get_unit_list() method.
    }
}

?>