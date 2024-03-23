<?php
/**
 * In File write
 * any key mapping helper functions regarding to opera
 */

/**
 * This will set room rates array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_room_rates(&$data, $value_to_map)
{
    /** Reflect data  for a Single RoomRate */
    if (isset($value_to_map['Rate']['Base'])) {
        $data['RoomStay']['RoomRates'][0]['Total'] = $data['RoomStay']['RoomRates'][0]['Base'] =
            [
                'AmountAfterTax' => $value_to_map['Rate']['Base']['text'],
                'AmountBeforeTax' => $value_to_map['Rate']['Base']['text'],
                'CurrencyCode' => $value_to_map['Rate']['Base']['@currencyCode'],
                'Taxes' => []
            ];

    } elseif (is_array($value_to_map['Rate'])) {
        /** Reflect data  for Nested or Multiple RoomRates */
        foreach ($value_to_map['Rate'] as $key => $rate) {
            $data['RoomStay']['RoomRates'][$key]['Total'] = $data['RoomStay']['RoomRates'][$key]['Base'] =
                [
                    'AmountAfterTax' => $rate['Base']['text'],
                    'AmountBeforeTax' => $rate['Base']['text'],
                    'CurrencyCode' => $rate['Base']['@currencyCode'],
                    'Taxes' => []
                ];
        }
    }
}


/**
 * This will set reservation comments array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_comments(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if (isset($value_to_map['Comment']['Text'])) {

        $data['RoomStay']['Comments'] = array(
            [
                'GuestViewable' => $value_to_map['Comment']['@guestViewable'],
                'Comment' => $value_to_map['Comment']['Text']
            ]
        );

    } elseif (is_array($value_to_map['Comment'])) {
        /** Reflect data  for Nested or Multiple Reservation Comments */
        foreach ($value_to_map['Comment'] as $key => $comment) {
            $data['RoomStay']['Comments'][$key] =
                [
                    'GuestViewable' => $comment['@guestViewable'],
                    'Comment' => $comment['Text']
                ];
        }
    }
}


/**
 * This will set Guests Count with Age qualifiers array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_guest_counts(&$data, $value_to_map)
{
    /** Reflect data  for a Single Reservation Comment */
    if (isset($value_to_map['GuestCount']['@ageQualifyingCode'])) {

        $data['GuestCounts'] = array(
            [
                'AgeQualifyingCode' => $value_to_map['GuestCount']['@ageQualifyingCode'],
                'Count' => $value_to_map['Comment']['@count']
            ]
        );

    } elseif (is_array($value_to_map['GuestCount'])) {
        /** Reflect data  for Nested or Multiple Reservation Comments */
        foreach ($value_to_map['GuestCount'] as $key => $guest_count) {
            $data['GuestCounts'][$key] =
                [
                    'AgeQualifyingCode' => $guest_count['@ageQualifyingCode'],
                    'Count' => $guest_count['@count']
                ];
        }
    }
}

/**
 * This will set Guests Count with Age qualifiers array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_taxes(&$data, $value_to_map)
{

    /** Reflect data  for a Single tax */
    if (isset($value_to_map['Charges']['Description'])) {

        $data['RoomStay']['Total']['Taxes'] = array(
            [
                'Code' => null,
                'Amount' => $value_to_map['Charges']['Amount']['text'],
                'CurrencyCode' => $value_to_map['Charges']['Amount']['@currencyCode'],
                'Percent' => 0.00
            ]
        );

    } elseif (is_array($value_to_map['Charges'])) {

        /** Reflect data  for Nested or Taxes */
        foreach ($value_to_map['Charges'] as $key => $charge) {
            $data['RoomStay']['Total']['Taxes'][$key] =
                [
                    'Code' => null,
                    'Amount' => $charge['Amount']['text'],
                    'CurrencyCode' => $charge['Amount']['@currencyCode'],
                    'Percent' => 0.00
                ];
        }
    } else {
        $data['RoomStay']['Total']['Taxes'] = array();
    }
}



/**
 * This will set Guests Count with Age qualifiers array to Reservation key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_reservation_deposit_payments(&$data, $value_to_map)
{
     $currency  = $data['RoomStay']['Total']['CurrencyCode'] ?? null;

    /** Reflect data  for a Single tax */
    if (isset($value_to_map['DueDate'])) {

        $data['RoomStay']['DepositPayments'] = array(
            ['Percent' => 0.00, 'CurrencyCode' => $currency, 'Amount' => $value_to_map['DepositAmount']['text'], 'Deadline' => $value_to_map['DueDate']]
        );

    } elseif (is_array($value_to_map)) {

        /** Reflect data  for Nested or Taxes */
        foreach ($value_to_map as $key => $deposit) {
            $data['RoomStay']['DepositPayments'] = array(
                ['Percent' => 0.00, 'CurrencyCode' => $currency, 'Amount' => $deposit['DepositAmount']['text'], 'Deadline' => $deposit['DueDate']]
            );
        }
    }
}

/**
 * This will set property contact phone numbers array to Property key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_property_contact_phones(&$data, $value_to_map)
{
    if (count($value_to_map) > 0) {

        foreach ($value_to_map as $key => $phone) {

            $data['HotelContactInformation']['ContactPhones'][$key] = [
                'Type' => $phone['@phoneRole'],
                'Number' => $phone['PhoneNumber']
            ];

        }

    }
}

/**
 * This will set property infos (TimeZone, CheckIn and CheckOut) array to Property key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_property_infos(&$data, $value_to_map)
{
    if (count($value_to_map) > 0) {

        foreach ($value_to_map as $hotel_info) {

            if (isset($hotel_info['@otherHotelInfoType']) && $hotel_info['@otherHotelInfoType'] == 'PROPERTY_TIMEZONE') {
                $data['HotelInformation']['TimeZone'] = $hotel_info['Text']['TextElement']['text'];
            }

            if (isset($hotel_info['@hotelInfoType']) && $hotel_info['@hotelInfoType'] == 'CHECKININFO') {
                $data['HotelInformation']['CheckIn'] = $hotel_info['Text']['TextElement']['text'];
            }

            if (isset($hotel_info['@hotelInfoType']) && $hotel_info['@hotelInfoType'] == 'CHECKOUTINFO') {
                $data['HotelInformation']['CheckOut'] = $hotel_info['Text']['TextElement']['text'];
            }

        }

    }
}

/**
 * This will set property rooms infos (Total Rooms, Code, Description and Name) array to Property key mapper data
 * provisioned us through Opera PMS request.
 * @param $data
 * @param $value_to_map
 */
function set_property_facility_infos(&$data, $value_to_map)
{
    if (isset($value_to_map['@totalRooms'])) {
        $data['FacilityInfo']['GuestRooms']['totalRooms'] = $value_to_map['@totalRooms'];
    }

    if (isset($value_to_map['GuestRoom']) && count($value_to_map['GuestRoom']) > 0) {

        foreach ($value_to_map['GuestRoom'] as $key => $guest_room) {

            $data['FacilityInfo']['GuestRooms']['GuestRoom'][$key] = [
                'code' => $guest_room['@code'],
                'name' => null,
                'description' => $guest_room['RoomDescription']['Text']['TextElement']['text'],
            ];

        }

    }
}

/**
 * This will Request transactionID
 * @param $data
 * @param $value_to_map
 */
function set_request_transaction_id(&$data, $value_to_map)
{
    $data['Envelope']['Header']['OGHeader']['@transactionID'] = 'CA-X_'.time();

}

/**
 * This will set request_timestamp key
 * @param $data
 * @param $value_to_map
 */
function set_request_timestamp(&$data, $value_to_map)
{
     $data['Envelope']['Header']['OGHeader']['@timeStamp'] = time();

}




