<?php

$mapper_helper_file = getPMSManifest()['mapper_helper_file'];

/**
 * Define all property response parameters in this file to send to the partner user.
 * on the left side of the array write the key that will come from pms response and
the key that we will send the CAX response to the partner user on the right side of the array.
 */

return [
    '' => 'HotelInformation.HotelCode',
    '' => 'HotelInformation.Name',
    '' => 'HotelInformation.NickName',
    '' => 'HotelInformation.TimeZone',
    '' => 'HotelInformation.Currency',
    '' => 'HotelInformation.CheckIn',
    '' => 'HotelInformation.CheckOut',
    '' => 'HotelContactInformation.Address.CountryCode',
    '' => 'HotelContactInformation.Address.CountryName',
    '' => 'HotelContactInformation.Address.Lat',
    '' => 'HotelContactInformation.Address.Lng',
    '' => 'HotelContactInformation.Address.StateCode',
    '' => 'HotelContactInformation.Address.StateName',
    '' => 'HotelContactInformation.Address.CityName',
    '' => 'HotelContactInformation.Address.ZipCode',
    '' => 'HotelContactInformation.Address.AddressLine',
];

?>