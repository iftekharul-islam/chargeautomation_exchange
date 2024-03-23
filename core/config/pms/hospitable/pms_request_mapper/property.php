<?php

/**
 * Define all request parameters in this file for fetching the property requests from Hospitable.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';
return [

    'property_single' => [
        PROPERTY_HOTEL_CODE => 'property_id',
    ],

    'property_list' => [
        RECORD_LIMIT => 'per_page',
        PAGE => 'page',
    ],
];

?>
