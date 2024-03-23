<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';

return [

    //The uuid of the reservation to retrieve.
    RESERVATION_PMS_RESERVATION_ID => 'uuid',
    RESERVATION_CONFIRMATION_NUMBER => 'reservation_code',
    //Array of property IDs to query for.
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => 'properties',
    //Find reservations with check-in/check-out dates after this day. Example: 2020-02-28. Match pattern: \d{4}-\d{2}-\d{2}
    RESERVATION_START_DATE => 'start_date',
    //Find reservations with check-in/check-out dates before this day. Example: 2020-02-28. Match pattern: \d{4}-\d{2}-\d{2}
    RESERVATION_END_DATE => 'end_date',

];

?>