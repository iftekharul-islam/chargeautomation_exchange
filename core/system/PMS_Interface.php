<?php


namespace Core\System;


interface PMS_Interface
{
    //public function get_account();//TODO

    //public function set_base_url();
    public function make_auth();

    /** Booking Details functions */
    public function get_booking();
    public function get_booking_list();
    public function update_booking();

    /** Properties details function */
    public function get_property();
    public function get_property_list();
    public function get_child_property_list();

    /** Guest details functions */
    public function get_guest();

    /** Webhook functions */
    public function add_webhook($type);
    public function update_webhook($type);
    public function delete_webhook($type);
    public function get_unit();
    public function get_unit_list();




}