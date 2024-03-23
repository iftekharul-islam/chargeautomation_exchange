<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';
$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all request parameters in this file for fetching the reservation requests from the PMS.
 * Put the request key of CAX constant on the left side of the array and the key that is used to request to PMS on the right side.
 */

return [
    RESERVATION_PMS_RESERVATION_ID => 'id',
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => 'accommodation',

    RESERVATION_START_DATE => 'startDate',
    RESERVATION_END_DATE => 'endDate',

    PAGE  => "__FILE__$mapper_helper_file@__FUNCTION__set_pagination",


];

?>