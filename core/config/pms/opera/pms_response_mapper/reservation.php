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
 * for example reference '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_reservation_room_rates'
 * Look into set_reservation_room_rates function of core/system/pms/opera/mapper_helper.php file
 *
 */

$HotelReservation = 'Envelope.Body.FetchBookingResponse.HotelReservation';
$ResGuest = $HotelReservation . '.ResGuests.ResGuest';
$RoomStay = $HotelReservation . '.RoomStays.RoomStay';

$RoomType = $RoomStay . '.RoomTypes.RoomType';
$RatePlan = $RoomStay . '.RatePlans.RatePlan';
$RoomRate = $RoomStay . '.RoomRates.RoomRate';
$Profile = $ResGuest . '.Profiles.Profile.0';

return [

    //-------------------------- ReservationInfo --------------------
    $HotelReservation . '.UniqueIDList.UniqueID.0.text' => 'ID',//TODO::
    $HotelReservation . '.@reservationStatus' => 'ResStatus',
    $HotelReservation . '.ReservationHistory.@insertDate' => 'CreateDateTime',
    $HotelReservation . '.ReservationHistory.@updateDate' => 'LastModifyDateTime',
    $HotelReservation . '.@sourceCode' => 'BookingChannel',
    $RoomStay . '.TimeSpan.StartDate' => 'TimeSpan.Start',
    $RoomStay . '.TimeSpan.EndDate' => 'TimeSpan.End',

    //------------------- Reservation PropertyInfos --------------------
    $RoomStay . '.HotelReference.@hotelCode' => 'BasicPropertyInfo.HotelCode',
    $RoomStay . '.HotelReference.text' => 'BasicPropertyInfo.HotelName',

    //-------------------- Reservation Guest--------------------------------
    $Profile . '.ProfileIDs.UniqueID.text' => 'ResGuest.Profiles.0.UniqueID',
    $Profile . '.Customer.PersonName.nameTitle' => 'ResGuest.Profiles.0.NamePrefix',
    $Profile . '.Customer.PersonName.firstName' => 'ResGuest.Profiles.0.GivenName',
    $Profile . '.Customer.PersonName.lastName' => 'ResGuest.Profiles.0.Surname',
    $Profile . '.Addresses.NameAddress.AddressLine' => 'ResGuest.Profiles.0.AddressLine',
    $Profile . '.Addresses.NameAddress.cityName' => 'ResGuest.Profiles.0.CityName',
    $Profile . '.Addresses.NameAddress.countryCode' => 'ResGuest.Profiles.0.CountryName',
    $Profile . '.Addresses.NameAddress.postalCode' => 'ResGuest.Profiles.0.PostalCode',
    ///'ResGuest.Profiles.0.Emails[]', ///TODO::Not found
    /// 'ResGuest.Profiles.0.Telephone[]', //TODO::Not found

    // ----------- RoomType Info ---------------------
    $RoomType . '.@roomTypeCode' => 'RoomStay.RoomType.RoomTypeCode',
    $RoomType . '.@roomTypeName' => 'RoomStay.RoomType.Name',
    $RoomType . '.RoomTypeDescription.Text' => 'RoomStay.RoomType.RoomDescription',
    $RoomType . '.RoomTypeShortDescription.Text' => 'RoomStay.RoomType.RoomShortDescription',

    // ------------- RatePlan ----------------------------------------
    $RatePlan . '.@ratePlanCode' => 'RoomStay.RatePlan.RatePlanCode',
    $RatePlan . '.@ratePlanName' => 'RoomStay.RatePlan.RatePlanName',
    $RatePlan . '.RatePlanDescription.Text' => 'RoomStay.RatePlan.RatePlanDescription',

    // ----------- Room Rates Array ----------------------------------------------
    $RoomRate . '.Rates' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_reservation_room_rates',

    // ----------- Guest Counts & Qualifier Array ----------------------------------------------
    $RoomStay . '.GuestCounts' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_reservation_guest_counts',

    // ----------- Reservation RoomStay Comments ----------------------------------------------
    $RoomStay . '.Comments' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_reservation_comments',

    // ----------- Reservation RoomStay Total Array ----------------------------------------------
    $RoomStay . '.Total.text' => 'RoomStay.Total.AmountAfterTax',
    $RoomStay . '.ExpectedCharges.@TotalRoomRateAndPackages' => 'RoomStay.Total.AmountBeforeTax',
    $RoomStay . '.Total.@currencyCode' => 'RoomStay.Total.CurrencyCode',
    $RoomStay . '.ExpectedCharges.ChargesForPostingDate.TaxesAndFees' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_reservation_taxes',

    // ----------- Reservation DepositPayments Array ----------------------------------------------
    $RatePlan . '.DepositRequired' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_reservation_deposit_payments',
];
