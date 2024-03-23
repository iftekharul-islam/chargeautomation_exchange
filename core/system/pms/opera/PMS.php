<?php


namespace Core\System\pms\opera;


use Core\System\Client\Client;use Core\System\PMS_Trait;
use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;

class PMS
{


    use PMS_Trait;

    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {

        $this->client = new Client();
    }

    /**
     * @return HotelReservation
     * @throws \CaxException
     */
    public function get_booking()
    {
        try {

            $endpoint_config = config('pms.' . getPmsName() . '.pms_endpoints', 'get_booking');
            $data_to_send = $this->makeRequestData('get_booking');

            $data = $this->client->sendRequest($endpoint_config['request_url'], 'POST', $data_to_send);

            $data = $this->formatResponseDataToArray($data, $endpoint_config);
            $booking = map_pms_keys_to_partner_keys('reservation', $data);

            return new HotelReservation($booking);

        } catch (\Exception $exception) {
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
            //TODO::Update
            return [$this->get_booking()];

        } catch (\Exception $exception) {
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


            $endpoint_config = config('pms.' . getPmsName() . '.pms_endpoints', 'get_property');
            $data = $this->makeRequestData('get_property');

            $data = $this->client->sendRequest($endpoint_config['request_url'], 'POST', $data);

            $data = $this->formatResponseDataToArray($data, $endpoint_config);

            $hotel = map_pms_keys_to_partner_keys( 'property', $data);
            return new Hotel($hotel);

        } catch (\Exception $exception) {
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

            //TODO::Update
            return [$this->get_property()];

        } catch (\Exception $exception) {
            throwException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}