<?php

require_once __DIR__ . '/../../../const/booking_sources_const.php';

/**
 * Define all the booking sources in this file which got from the PMS.
 * the Booking source value that will come from PMS write on the left side of the array and the booking source of CAX constant on the right side of the array.
 * 
 * link [https://app.lodgify.com/api/channels/status]
 *  At booking page
 *  @payload { "AirbnbIntegration", "Airbnb",  "BookingCom",  "ICalSync",  "NineFlats",  "HomeAwayIntegration", "Expedia" }
 *  @response data.appsInfo
 */

return [
    "Airbnb" => AIRBNB,
    "Booking.com" => BOOKING_DOT_COM,
    "Vrbo" => VRBO,
    "Expedia" => EXPEDIA,
    "Manual" => DIRECT,
    "" => DIRECT,
    // "Other" => OTHER,
    // I don't know about these below is booking source:
    "ICalSync" => ICAL_SYNC,
    "BookingCom" => BOOKING_DOT_COM,
    "B_Com" => BOOKING_DOT_COM,
    "AirbnbIntegration" => AIRBNB,
    "HomeAwayIntegration" => HOME_AWAY_INTEGRATION,
    "Gvr" => GVR
];