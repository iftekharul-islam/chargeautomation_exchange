<?php

namespace Core\System\pms\owner_rez;

use Core\System\PMS_Interface;
use Core\System\PMS_Trait;
use Core\System\ResponseInstance\CustomField\CustomField;
use Core\System\ResponseInstance\CustomField\CustomFieldDefinition;
use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\HotelReservation\Guest\Guest;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;

require_once __DIR__ . '/../../../const/pms_endpoints_const.php';

class  PMS implements PMS_Interface
{
    use PMS_Trait, PMS_Helper;

    public function __construct($set_auth = true)
    {
        $this->_initiate_construct();

        if ($set_auth) {
            $this->setAuth();
        }

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
            return $this->makeCaxReservationInstances($formatted_response['items'] ?? []);
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
            return $this->makeCaxHotelInstances(($formatted_response['items'] ?? []));

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
            if (!empty($formatted_response['id'])) {
                return new Guest(map_pms_keys_to_partner_keys('guest', $formatted_response));
            }

        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return null;
    }

    public function make_auth()
    {
        // TODO: Implement make_auth() method.
    }


    /**
     * @return string
     */
    public static function oauth_url()
    {
        return $_ENV['OWNER_REZ_OAUTH_URL'] . "/oauth/authorize?response_type=code&client_id=" . $_ENV['OWNER_REZ_CLIENT_ID'];
    }

    /**
     * @param $code
     * @return false|string
     * @throws \Exception
     */
    public function authenticateAccessCode($code)
    {
        $api = $_ENV['OWNER_REZ_OAUTH_URL'] . "/oauth/access_token";

        $data = [

            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(($_ENV['OWNER_REZ_CLIENT_ID'] . ':' . $_ENV['OWNER_REZ_CLIENT_SECRET'])),
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],

            'form_params' => ['grant_type' => 'authorization_code', 'code' => $code]
        ];

        return json_encode($this->client->sendRequest($api, 'POST', $data), true);
    }

    /**
     * @throws \CaxException
     */
    public function update_booking()
    {
        throwException(CAX_EXCEPTION_MESSAGES[CAX_REQUEST_NOT_SUPPORTED], CAX_REQUEST_NOT_SUPPORTED);
    }

    public function add_webhook($type)
    {
        // TODO: Implement add_webhook() method.
    }

    public function update_webhook($type)
    {
        // TODO: Implement update_webhook() method.
    }

    public function delete_webhook($type)
    {
        // TODO: Implement delete_webhook() method.
    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function get_custom_item_definition()
    {
        try {

            $formatted_response = $this->getFormattedResponse(
                'custom_item_definition',
                'custom_item_definition.single.read',
                'custom_item_definition_single'
            );

            return !empty($formatted_response['id'])
                ? new CustomFieldDefinition(map_pms_keys_to_partner_keys('custom_item_definition', $formatted_response))
                : null;

        } catch (\Exception $exception) {
            throw new \CaxException($exception->getMessage(), $exception->getCode(), $exception); //TODO::UPDATE
        }
    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function get_custom_item_definition_list()
    {

        try {

            $custom_item_definitions = [];
            $formatted_response = $this->getFormattedResponse('custom_item_definition', 'custom_item_definition.list.read', 'custom_item_definition_list');

            if (empty($formatted_response['items'])) {
                return [];
            }

            foreach ($formatted_response['items'] as $item) {
                $custom_item_definitions[] = new CustomFieldDefinition(map_pms_keys_to_partner_keys('custom_item_definition', $item));
            }

        } catch (\Exception $exception) {
            throw new \CaxException($exception->getMessage(), $exception->getCode(), $exception); //TODO::UPDATE
        }

        return $custom_item_definitions; //TODO
    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function add_custom_item_definition()
    {
        try {

            $formatted_response = $this->getFormattedResponse(
                'custom_item_definition',
                'custom_item_definition.single.write',
                'custom_item_definition_single'
            );

            return !empty($formatted_response['id'])
                ? new CustomFieldDefinition(map_pms_keys_to_partner_keys('custom_item_definition', $formatted_response))
                : null;


        } catch (\Exception $exception) {
            throw new \CaxException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }


    /**
     * @return mixed
     * @throws \CaxException
     */
    public function get_custom_item()
    {
        try {


            $formatted_response = $this->getFormattedResponse(
                'custom_item',
                'custom_item.single.read',
                'custom_item_single'
            );

            return !empty($formatted_response['id'])
                ? new CustomField(map_pms_keys_to_partner_keys('custom_item', $formatted_response))
                : null;

        } catch (\Exception $exception) {
            throw new \CaxException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function get_custom_item_list()
    {
        try {

            $custom_items = [];
            $formatted_response = $this->getFormattedResponse(
                'custom_item',
                'custom_item.list.read',
                'custom_item_list'
            );

            if (empty($formatted_response['items'])) {
                return [];
            }

            foreach ($formatted_response['items'] as $item) {
                $custom_items[] = new CustomField(map_pms_keys_to_partner_keys('custom_item', $item));
            }

        } catch (\Exception $exception) {
            throw new \CaxException($exception->getMessage(), $exception->getCode(), $exception); //TODO::UPDATE
        }

        return $custom_items;

    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function add_custom_item()
    {
        try {

            $formatted_response = $this->getFormattedResponse(
                'custom_item',
                'custom_item.single.write',
                'custom_item_single'
            );

            return !empty($formatted_response['id'])
                ? new CustomField(map_pms_keys_to_partner_keys('custom_item', $formatted_response))
                : null;


        } catch (\Exception $exception) {
            throw new \CaxException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }


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