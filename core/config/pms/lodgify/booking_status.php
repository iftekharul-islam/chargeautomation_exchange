<?php

require_once __DIR__ . '/../../../const/booking_status_const.php';

/**
 * Define all the reservation statuses in this file which got from the PMS.
 * the Booking status value that will come from PMS write on the left side of the array and the booking status of CAX constant on the right side of the array.
 * 
 * Get the booking status from this link [https://docs.lodgify.com/reference/post_v1-reservation-booking-1#body-postV1ReservationBooking_status]
 */

return [
    "Open" => BLOCKED,
    "Tentative" => BLOCKED,
    "Declined" => CANCELED,
    "Booked" => CONFIRMED,
    "Unavailable" => IGNORED,
    'ClosedPeriod' => BLOCKED
];