<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';

/**
 * Define all request parameters in this file for fetching the guest requests from the PMS.
 * Put the request key of CAX constant on the left side of the array and the key that is used to request to PMS on the right side.
 */

return [
    RESERVATION_GUEST_ID => null,
    RESERVATION_GUEST_FIRST_NAME => null,
    RESERVATION_GUEST_LAST_NAME => null,
    RESERVATION_GUEST_PHONE => null,
    RESERVATION_GUEST_EMAIL => null,
];

?>