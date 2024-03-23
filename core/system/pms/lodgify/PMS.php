<?php

namespace Core\System\pms\lodgify;

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
        'booking_new_status_booked',
        'booking_change',
        'booking_status_change_booked',
        'booking_status_change_open',
        'booking_status_change_declined'
    ];

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
            return $this->makeCaxReservationInstances($formatted_response['items']??[]);
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

            $formatted_response = $this->getFormattedResponse('property', 'property.list.read');
            return $this->makeCaxHotelInstances(($formatted_response['items']??[]));

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

    /**
     * @throws \CaxException
     */
    public function make_auth()
    {
        // TODO: Implement make_auth() method.
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
            if ($type != config('db_config.partner_webhook_settings', 'type.booking')) {
                return true;
            }

            $pms_webhooks = $this->list_webhooks();
            $webhook_url = $this->getWebhookURL(config('db_config.partner_webhook_settings', 'type.booking'));


            foreach ($this->webhook_types as $webhook_type) {
                if (empty($this->filterPMSEnabledWebhook($pms_webhooks, $webhook_type, $webhook_url))) {
                    $this->client->sendRequest($this->base_url . 'webhooks/v1/subscribe', 'POST',
                        [
                            'headers' => $this->headers,
                            'json' => ['event' => $webhook_type, 'target_url' => $webhook_url.'&event='.$webhook_type]
                        ]
                    );
                }
            }

            return true;

        } catch (\Exception $exception) {
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

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
                    $this->client->sendRequest(($this->base_url . 'webhooks/v1/unsubscribe'), 'DELETE ',
                        [
                            'headers' => $this->headers,
                            'json' => ['id' => $pms_webhook['id']]
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
     * @return array
     * @throws \CaxException
     */
    private function list_webhooks()
    {
        $response = $this->client->sendRequest($this->base_url . 'webhooks/v1/list', 'GET', ['headers' => $this->headers]);

        $response = json_decode($response, true);

        return !empty($response[0]['event']) ? $response : [];
    }

    /**
     * @return mixed
     */
    public function get_child_property_list()
    {
        return [];
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