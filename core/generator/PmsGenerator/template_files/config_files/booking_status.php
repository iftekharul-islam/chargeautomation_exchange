<?php

require_once __DIR__ . '/../../../const/booking_status_const.php';

/**
 * Define all the reservation statuses in this file which got from the PMS.
 * the Booking status value that will come from PMS write on the left side of the array and the booking status of CAX constant on the right side of the array.
 */

return [
    '' => ACTIVE,
    '' => CANCELED,
    '' => PENDING,
    '' => INQUIRY,
    '' => CONFIRMED,
    '' => CANCELLED,
    '' => NEW_BOOKING,
    '' => REQUEST,
    '' => BLOCKED,
    '' => IGNORED,
];