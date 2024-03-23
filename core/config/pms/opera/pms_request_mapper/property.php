<?php

/**
 * Define all request parameters in this file for fetching the property requests from Opera.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';
return [

    'property_single' => [
        //Any email addresses associated with the hotel.
        //Type: element
        //Data Type: ArrayOfEmail
        PROPERTY_CONTACT_EMAILS => 'Body.FetchHotelRequest.ContactEmails',

        //Hotel phone number information.
        //Type: element
        //Data Type: ArrayOfPhone
        PROPERTY_CONTACT_PHONES => 'Body.FetchHotelRequest.ContactPhones',

        //The chain code.
        //Type: attribute
        //Data Type: string
        PROPERTY_CHAIN_CODE => 'Body.FetchHotelRequest.chainCode',

        //The hotel code.
        //Type: attribute
        //Data Type: string
        PROPERTY_HOTEL_CODE => 'Body.FetchHotelRequest.hotelCode',
    ],

    'property_list' => [],
];