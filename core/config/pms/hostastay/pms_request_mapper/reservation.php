<?php
require_once __DIR__ . '/../../../../system/cax_request_keys.php';

return [
    RESERVATION_PMS_RESERVATION_ID => 'code',
    RESERVATION_HOTEL_REFERENCE_HOTEL_CODE => 'unit_id',

    //Find reservations with check-in/check-out dates after this day. Example: 2020-02-28. Match pattern: \d{4}-\d{2}-\d{2}
    RESERVATION_START_DATE => 'check_in_date',
    //Find reservations with check-in/check-out dates before this day. Example: 2020-02-28. Match pattern: \d{4}-\d{2}-\d{2}
    RESERVATION_END_DATE => 'check_out_date',

    RESERVATION_PMS_RESERVATION_STATUS => 'status',
    RESERVATION_NOTES => 'remarks',

    // Reservation Guest
    RESERVATION_GUEST_FIRST_NAME => 'guest_details.first_name',
    RESERVATION_GUEST_LAST_NAME => 'guest_details.last_name',
    RESERVATION_GUEST_PHONE => 'guest_details.contact_no',
    RESERVATION_GUEST_EMAIL => 'guest_details.email',


];

?>