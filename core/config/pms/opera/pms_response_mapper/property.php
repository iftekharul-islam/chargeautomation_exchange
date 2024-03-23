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

$Hotel = 'Envelope.Body.HotelInformationResponse.HotelInformation';

$HotelInformation = $Hotel . '.HotelInformation';
$HotelContactInformation = $Hotel . '.HotelContactInformation';
$HotelExtendedInformation = $Hotel . '.HotelExtendedInformation';

return [
    $HotelInformation . '.@chainCode' => 'HotelInformation.ChainCode',
    $HotelInformation . '.@hotelCode' => 'HotelInformation.HotelCode',
    $HotelInformation . '.text' => 'HotelInformation.Name',
    $HotelContactInformation . '.Addresses.Address.AddressLine' => 'HotelContactInformation.Address.AddressLine',
    $HotelContactInformation . '.Addresses.Address.cityName' => 'HotelContactInformation.Address.CityName',
    $HotelContactInformation . '.Addresses.Address.countryCode' => 'HotelContactInformation.Address.CountryCode',
    $HotelContactInformation . '.ContactEmails.ContactEmail' => 'HotelContactInformation.ContactEmail',
    $HotelContactInformation . '.ContactPhones.Phone' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_property_contact_phones',
    $HotelExtendedInformation . '.HotelInformation.HotelInfo' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_property_infos',
    $HotelExtendedInformation . '.FacilityInfo.GuestRooms' => '__FILE__core/system/pms/opera/mapper_helper@__FUNCTION__set_property_facility_infos',
];