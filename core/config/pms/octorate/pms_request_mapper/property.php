<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';
$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all request parameters in this file for fetching the property requests from the PMS.
 * Put the request key of CAX constant on the left side of the "property_single" and "property_list" arrays and the key that is used to request to PMS on the right side.
 */

return [
    'property_single' => [
        PROPERTY_HOTEL_CODE => 'accommodation',
    ],

    'property_list' => [
        RECORD_LIMIT => 'per_page',
        PAGE  => "__FILE__$mapper_helper_file@__FUNCTION__set_pagination",
    ],
];

?>