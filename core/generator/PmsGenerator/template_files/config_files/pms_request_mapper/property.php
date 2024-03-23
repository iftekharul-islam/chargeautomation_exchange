<?php

/**
 * Define all request parameters in this file for fetching the property requests from the PMS.
 * Put the request key of CAX constant on the left side of the "property_single" and "property_list" arrays and the key that is used to request to PMS on the right side.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';
return [

    'property_single' => [
        PROPERTY_CONTACT_EMAILS => null,
        PROPERTY_CONTACT_PHONES => null,
        PROPERTY_CHAIN_CODE => null,
        PROPERTY_HOTEL_CODE => null,
    ],

    'property_list' => [
        PROPERTY_CONTACT_EMAILS => null,
        PROPERTY_CONTACT_PHONES => null,
        PROPERTY_CHAIN_CODE => null,
        PROPERTY_HOTEL_CODE => null,
    ],

];

?>
