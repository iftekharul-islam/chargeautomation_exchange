<?php

/**
 * Notes:
 *
 * To simply map PMS keys to Key on CA-x just write down the PMS key on left side
 * and write CA-X instance key on right side to where the actual value would be mapped.
 *
 * To map any kind of complex key as per your own custom logics or nested index wise keys
 * __FILE__{FILE-PATH}@__FUNCTION__{FunctionName}
 *
 * Use the provided formatted function path this function will be auto called by mapper_helper to map complex keys
 * for example reference '__FILE__$mapper_helper_file@__FUNCTION__set_reservation_room_rates'
 * Look into set_reservation_room_rates function of $mapper_helper_file.php file
 *
 */

$mapper_helper_file = getPMSManifest(OWNER_REZ)['mapper_helper_file'];

return [
    //-------------------------- ReservationInfo --------------------
    'id' => 'ID',

    //If Booking Type is Block then set Booking status as Blocked.
    'type' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',
    'status' => '__FILE__helpers/global_helper@__FUNCTION__setBookingStatus',

    'booked_utc' => 'CreateDateTime',
    'listing_site' => '__FILE__helpers/global_helper@__FUNCTION__setBookingSource',
    'arrival' => 'TimeSpan.Start',
    'departure' => 'TimeSpan.End',
    'currency_code' => 'RoomStay.Total.CurrencyCode',

    //------------------- Reservation PropertyInfos --------------------
    'property_id' => 'BasicPropertyInfo.HotelCode',

    //-------------------- Reservation Guest--------------------------------
    'guest_id' => 'ResGuest.Profiles.0.UniqueID',
    'guest.first_name' => 'ResGuest.Profiles.0.GivenName',
    'guest.last_name' => 'ResGuest.Profiles.0.Surname',



    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    'adults' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_adult_counts",
    'children' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_child_counts",

    // ----------- Reservation RoomStay Comments ----------------------------------------------
    'notes' => "__FILE__$mapper_helper_file@__FUNCTION__set_reservation_comments",

    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    'total_amount' => 'RoomStay.Total.AmountAfterTax',
    'total_paid' => 'RoomStay.Total.AmountPaid',
//    'total_amount' => 'RoomStay.Total.AmountBeforeTax',

];
