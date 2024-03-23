<?php
/**
 * In File write
 * any key mapping helper functions regarding to OwnerRez
 */


/**
 * This will set reservation comments array to Reservation key mapper data
 * provisioned us through OwnerRez PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_comments(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if (!empty($value_to_map)) {

        $data['RoomStay']['Comments'] = array(
            [
                'GuestViewable' => false,
                'Comment' => $value_to_map
            ]
        );

    }
}


/**
 * This will set Guests Count with Age qualifiers array to Reservation key mapper data
 * provisioned us through OwnerRez PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_adult_counts(&$data, $value_to_map)
{

    /** Reflect data  for a Single Reservation Comment */
    if (!is_null($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
                'AgeQualifyingCode' => 'adults',
                'Count' => $value_to_map
        ];
    }
}

function set_reservation_child_counts(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if(!is_null($value_to_map)) {
        $data['RoomStay']['GuestCounts'][] = [
                'AgeQualifyingCode' => 'children',
                'Count' => $value_to_map
        ];
    }
}

function set_guest_address_line(&$data, $value_to_map) {
    $data['Profiles'][0]['AddressLine'] = (!empty($value_to_map[0]['street1'])? ($value_to_map[0]['street1'].' '): '') . ($value_to_map[0]['street2']??'');
}

function set_guest_emails(&$data, $value_to_map) {
    $data['Profiles'][0]['Emails'] = array_column($value_to_map, 'address');
}

function set_guest_phones(&$data, $value_to_map) {
    foreach ($value_to_map as $phone) {
        $data['Profiles'][0]['Telephone'][] = ['PhoneNumber' => $phone['number'], 'PhoneTechType' => $phone['type']];
    }
}
