<?php

/**
 * Define all request parameters in this file for fetching the property requests from OwnerRez.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';
return [

    'property_single' => [
        //The hotel id.
        //Data Type: string
        PROPERTY_HOTEL_CODE => 'id',
    ],

    'property_list' => [
        RECORD_LIMIT => RECORD_LIMIT,
        RECORD_OFFSET => RECORD_OFFSET,
    ],
];