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
        // TODO: Implement get_booking() method.
    }

    /**
     * @return HotelReservation[]
     * @throws \CaxException
     */
    public function get_booking_list()
    {
        // TODO: Implement get_booking_list() method.
    }

    /**
     * @return Hotel
     * @throws \CaxException
     */
    public function get_property()
    {
        // TODO: Implement get_property() method.
    }

    /**
     * @return Hotel[]
     * @throws \CaxException
     */
    public function get_property_list()
    {
        // TODO: Implement get_property_list() method.
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
}

?>