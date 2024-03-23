<?php

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_property_contact_number(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['HotelContactInformation']['ContactPhones'][0] =
            [
                'Type' => 'PHONE',
                'Number' => $value_to_map
            ];

    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_property_checkin(&$data, $value_to_map)
{
    if (!is_null($value_to_map)) {
        $data['HotelInformation']['CheckIn'] = str_contains($value_to_map, ':') ? $value_to_map : "$value_to_map:00";
    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_property_checkout(&$data, $value_to_map)
{
    if (!is_null($value_to_map)) {
        $data['HotelInformation']['CheckOut'] = str_contains($value_to_map, ':') ? $value_to_map : "$value_to_map:00";
    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_guest_phones(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['Profiles'][0]['Telephone'][] = ['PhoneNumber' => $value_to_map, 'PhoneTechType' => 'PHONE'];
    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_reservation_infant_counts(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'infant',
            'Count' => $value_to_map
        ];
    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_reservation_child_counts(&$data, $value_to_map)
{
    if (!empty($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'children',
            'Count' => $value_to_map
        ];
    }
}

/**
 * @param $data
 * @param $value_to_map
 * @return void
 */
function set_reservation_guest_counts(&$data, $value_to_map)
{
    $otherGuests = 0;
    if(!empty($data['RoomStay']['GuestCounts'])){
        foreach($data['RoomStay']['GuestCounts'] as $guestCount){
            if($guestCount['AgeQualifyingCode'] == 'children'){
                $otherGuests += $guestCount['Count'];
            }
        }
    }

    if (!empty($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
            'AgeQualifyingCode' => 'adults',
            'Count' => $value_to_map - $otherGuests,
        ];
    }
}


/**
 * @param $data
 * @param $value_to_map
 */
function set_pagination(&$data, $value_to_map){

    if(!empty($value_to_map)) {
        // Octorate PMS assume page not set as 1
        // and page value 1 as page 2 in request param (0 index)
        $_REQUEST[PAGE] = (int) $value_to_map-1;
    }
}

function changeDateToGMT($date){
    $dateTime = new DateTime(str_replace('[UTC]', '',$date));
    $dateTime->setTimezone(new DateTimeZone('GMT'));
    return $dateTime->format('Y-m-d H:i:s');
}

/**
 * @param $data
 * @param $value_to_map
 */
function set_bookingTime(&$data, $value_to_map){
    $data['CreateDateTime'] = changeDateToGMT($value_to_map);
}

/**
 * @param $data
 * @param $value_to_map
 */
function set_checkin(&$data, $value_to_map){
    $data['TimeSpan']['Start'] = changeDateToGMT($value_to_map);
}

/**
 * @param $data
 * @param $value_to_map
 */
function set_checkout(&$data, $value_to_map){
    $data['TimeSpan']['End'] = changeDateToGMT($value_to_map);
}


?>