<?php

/**
 * Define all request parameters in this file for fetching the reservation requests from OwnerRez.
 */

require_once __DIR__ . '/../../../../system/cax_request_keys.php';
return [

    RESERVATION_PMS_RESERVATION_ID => 'id',

    // List Reservations
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => 'property_ids',
    RESERVATION_CREATED_DATE => 'from',

];