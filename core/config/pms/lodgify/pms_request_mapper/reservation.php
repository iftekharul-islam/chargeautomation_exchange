<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';

/**
 * Define all request parameters in this file for fetching the reservation requests from the PMS.
 * Put the request key of CAX constant on the left side of the array and the key that is used to request to PMS on the right side.
 */

return [
    RESERVATION_PMS_RESERVATION_ID => 'id',
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => 'propertyId'
];

?>