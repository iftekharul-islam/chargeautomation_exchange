<?php

require_once __DIR__ . '/../../../const/booking_status_const.php';

/**
 * Define all the reservation statuses in this file which got from the PMS.
 * the Booking status value that will come from PMS write on the left side of the array and the booking status of CAX constant on the right side of the array.
 *
 * get booking status form docs [https://api.octorate.com/connect/redocly.html#tag/Property:-Reservations/operation/findReservations]
 */
return [
    "CANCELLED" =>  CANCELLED,
    "WAITING" =>  BLOCKED, 
    "CONFIRMED" =>  CONFIRMED,
    "ACTIVE" =>  BLOCKED,
    "NOROOM" =>  BLOCKED,
    "COMPLETED" =>  CONFIRMED,
    "NOCOMPLETED" =>  BLOCKED,
    "NEWMESSAGE" =>  BLOCKED,
    "EXPIREDMESSAGE" =>  BLOCKED,
    "PROPOSAL" =>  BLOCKED,
    "NOT_INVOICED" =>  BLOCKED,
    "DEPOSIT_NOT_MANAGED" =>  BLOCKED,
    "DEPOSIT_IN_WAITING" =>  BLOCKED,
    "TO_REVIEW" => INQUIRY
];