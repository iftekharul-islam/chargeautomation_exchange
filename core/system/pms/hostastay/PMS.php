<?php

namespace Core\System\pms\hostastay;

use Core\System\PMS_Interface;
use Core\System\PMS_Trait;
use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\HotelReservation\Guest\Guest;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;

require_once __DIR__ . '/../../../const/pms_endpoints_const.php';

class  PMS implements PMS_Interface
{
    use PMS_Trait, PMS_Helper;

    public function __construct()
    {
        $this->_initiate_construct();
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
            $hotels = isset($formatted_response['unit']) ? [$formatted_response['unit']]: [];
            return $this->makeCaxHotelInstances($hotels)[0] ?? null;

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
            return $this->makeCaxHotelInstances(($formatted_response['units'] ?? []));

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
            return new Guest([]);
        } catch (\Exception $exception) {
            if ($exception->getCode() == 404) {
                return null;
            }
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }

    }

    /**
     * @throws \CaxException
     */
    public function make_auth()
    {
        try {

            $user_credentials = getUserCredentials();
            $data = ['headers' => ['Access-Token' => $user_credentials['access_token']]];
            $this->client->sendRequest(($this->base_url . '/room?property_id=' . $user_credentials['property_id']), 'GET', $data);

        } catch (\Exception $exception) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR].' Invalid Access-Token.', CAX_CLIENT_UNAUTHORIZED_ERROR, $exception);
        }

    }

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