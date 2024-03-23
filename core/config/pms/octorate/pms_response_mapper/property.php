<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all property response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */

return [
    'name' => 'HotelInformation.Name',
    'id' => 'HotelInformation.HotelCode',
    'timeZone.displayName' => 'HotelInformation.TimeZone',

    /* Actual property having: networkActive = True, masterCalendar = false*/
    'masterCalendar' => 'HotelInformation.MasterCalendar',
    'networkActive' => 'HotelInformation.NetworkActive',

    'checkinStart' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_checkin",
    'Checkout' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_checkout",

    'currency' => 'HotelInformation.Currency',
    'address' => "HotelContactInformation.Address.AddressLine",
    'city' => "HotelContactInformation.Address.CityName",
    'country' => "HotelContactInformation.Address.CountryCode",
    'zipCode' => "HotelContactInformation.Address.ZipCode",
    'latitude' => "HotelContactInformation.Address.Lat",
    'longitude' => "HotelContactInformation.Address.Lng",
    'contact.email' => "HotelContactInformation.ContactEmail",
    'contact.phoneNumber' => "__FILE__$mapper_helper_file@__FUNCTION__set_property_contact_number",
];

?>
