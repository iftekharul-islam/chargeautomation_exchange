<?php

namespace Core\System\pms\hospitable;

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
            $reservation = !empty($formatted_response['data']) ? [$formatted_response['data']] : [];
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
            $hotels = !empty($formatted_response['data']) ? [$formatted_response['data']] : [];
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
            return $this->makeCaxHotelInstances(($formatted_response['data'] ?? []));

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

            $data = [
                'form_params' => [
                    "client_id" => $user_credentials['client_id'] ?? '', //"19327c93-3347-4276-ad41-3252a97b7f26", //TODO
                    "client_secret" => $user_credentials['client_secret'] ?? '', //"8b737039b2d79c4de55183d96bb3092bbabc8aec8218dabdba3781acf1da72031",//TODO
                    "audience" => "api.hospitable.com",
                    "grant_type" => "client_credentials"
                ]
            ];

            $response = $this->client->sendRequest('https://auth.hospitable.com/oauth/token', 'POST', $data);
            $response = json_decode($response, true);

            if (empty($response['access_token'])) {
                throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
            }

            // Set OAuth token expiration date
            $response['expires_in'] += (time() - 20);
            $user_credentials = array_merge($user_credentials, $response);

            // Update DB values
            DB::executeStatement(
                'UPDATE `partner_users` SET  credentials=:credentials WHERE id=:id AND partner_id=:partner_id',
                ['id' => getPartnerUserId(), 'credentials' => json_encode($user_credentials), 'partner_id' => getPartnerId()]
            );

            // Update global values
            setUserCredentials($user_credentials);

        } catch (\Exception $exception) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
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