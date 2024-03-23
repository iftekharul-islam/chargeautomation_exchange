<?php

namespace Core\System;

use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\HotelReservation\Guest\Guest;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;

require_once __DIR__ . '/../includes/autoload.php';
require_once __DIR__ . '/../../core/system/cax_request_keys.php';



class PMS implements PMS_Interface
{

    /**
     * Object Instance of session's relevant PMS class
     * @var \Core\System\pms\opera\PMS | \Core\System\pms\owner_rez\PMS
     */
    private $pms;

    public function __construct()
    {
        $this->__initiatePmsObjectInstance();
    }


    /**
     * Authenticate or create Auth if needed for the PMS.
     * @return mixed
     */
    public function make_auth()
    {
        return $this->callRelevantClassMethod(__FUNCTION__);
    }

    /**
     * @return HotelReservation
     * @throws \CaxException
     */
    public function get_booking()
    {
        $this->isApiSupported('booking', true, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }

    /**
     * @return HotelReservation[]
     * @throws \CaxException
     */
    public function get_booking_list()
    {
        $this->isApiSupported('booking', false, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }

    /**
     * @return HotelReservation
     * @throws \CaxException
     */
    public function update_booking()
    {
        $this->isApiSupported('booking', true, true);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }


    /**
     * @return Hotel
     * @throws \CaxException
     */
    public function get_property()
    {
        $this->isApiSupported('property', true, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }


    /**
     * @return Hotel[]
     * @throws \CaxException
     */
    public function get_property_list()
    {
        $this->isApiSupported('property', false, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }

    /**
     * @return Hotel
     * @throws \CaxException
     */
    public function get_unit()
    {
        $this->isApiSupported('unit', true, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }


    /**
     * @return Hotel[]
     * @throws \CaxException
     */
    public function get_unit_list()
    {
        $this->isApiSupported('unit', false, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }

    /**
     * @return Hotel[]
     * @throws \CaxException
     */
    public function get_child_property_list()
    {
        $this->isApiSupported('child_property', false, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }

    /**
     * @return Guest
     * @throws \CaxException
     */
    public function get_guest()
    {
        $this->isApiSupported('guest', true, false);
        return $this->callRelevantClassMethod(__FUNCTION__);
    }


    /**
     * Initiate relevant PMS class instance
     */
    private function __initiatePmsObjectInstance()
    {
        $file = '\Core\System\pms\\' . getPmsName() . '\\PMS';
        $this->pms = new $file();
    }

    private function callRelevantClassMethod($functionName, $params = [])
    {
        return $this->pms->{$functionName}(...$params);
    }

    public function set_base_url()
    {
        // TODO: Implement set_base_url() method.
    }

    /**
     * Validates whether the Request Supported by the User's PMS on CAX
     * @param $request_name
     * @param bool $single
     * @param false $write
     * @return bool
     * @throws \CaxException
     */
    private function isApiSupported($request_name, $single = true, $write = false)
    {
        if (!isManifestRequestAvailable($request_name, $single, $write)) {
            throw new \CaxException('Not Supported.', CAX_REQUEST_NOT_SUPPORTED);
        }

        return true;
    }


    /**
     * Validates whether the Request Supported by the User's PMS on CAX
     * @param $webhook_type
     * @return bool
     * @throws \CaxException
     */
    private function isWebhookSupported($webhook_type)
    {
        if (!isWebhookEnabledInManifest($webhook_type)) {
            throw new \CaxException('Not Supported.', CAX_REQUEST_NOT_SUPPORTED);
        }

        return true;
    }

    /**
     * @param $type
     * @return mixed
     * @throws \CaxException
     */
    public function add_webhook($type)
    {
        $this->isWebhookSupported($type);
        return $this->callRelevantClassMethod(__FUNCTION__, [$type]);
    }

    /**
     * @param $type
     * @return mixed
     * @throws \CaxException
     */
    public function update_webhook($type)
    {
        $this->isWebhookSupported($type);
        return $this->callRelevantClassMethod(__FUNCTION__, [$type]);
    }

    public function delete_webhook($type)
    {
        return $this->callRelevantClassMethod(__FUNCTION__, [$type]);
    }


    /**
     * @return mixed
     * @throws \CaxException
     */
    public function get_custom_item()
    {
        return $this->call_request_method(($_REQUEST[CAX_REQUEST_NAME_KEY]??null), true, false);
    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function get_custom_item_list()
    {
        return $this->call_request_method(($_REQUEST[CAX_REQUEST_NAME_KEY]??null), false, false);
    }

    /**
     * @return mixed
     * @throws \CaxException
     */
    public function add_custom_item()
    {
        return $this->call_request_method(($_REQUEST[CAX_REQUEST_NAME_KEY]??null), true, true);
    }

    /**
     * @param $request_name
     * @param false $is_single
     * @param false $is_write
     * @return mixed
     * @throws \CaxException
     */
    private function call_request_method($request_name, $is_single=false, $is_write=false)
    {
        $__function = $is_write ? "add_$request_name": "get_$request_name";
        $__function .= $is_single ? '' : '_list';

        switch ($request_name) {
            case REQUEST_NAME_CUSTOM_FIELD_DEFINITION:
            case REQUEST_NAME_CUSTOM_FIELD:
                $this->isApiSupported($request_name, $is_single, $is_write);
                return $this->callRelevantClassMethod($__function);
                default:
                    throw new \CaxException(
                        (
                            'Invalid request_name. It must be one of the following: '.
                            implode(', ' ,[REQUEST_NAME_CUSTOM_FIELD_DEFINITION, REQUEST_NAME_CUSTOM_FIELD])
                        ),
                        CAX_VALIDATION_ERROR
                    );

        }
    }
}