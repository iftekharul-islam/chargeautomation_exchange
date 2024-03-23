<?php


namespace Core\System;


use Core\System\ResponseInstance\Hotel\Hotel;
use Core\System\ResponseInstance\Hotel\Unit;
use Core\System\ResponseInstance\HotelReservation\HotelReservation;

trait PMS_ResponseHelper
{

    /**
     * @param array $pms_hotels
     * @return array
     */
    public function makeCaxHotelInstances(array $pms_hotels=[]) : array
    {
        foreach ($pms_hotels as $item) {
            $cax_hotels[] = new Hotel(map_pms_keys_to_partner_keys('property', $item));
        }

        return $cax_hotels ?? [];
    }

    /**
     * @param array $pms_units
     * @return array
     */
    public function makeCaxUnitInstances(array $pms_units=[]) : array
    {
        foreach ($pms_units as $item) {
             $cax_units[] = new Unit(map_pms_keys_to_partner_keys('unit', $item));
        }

        return $cax_units ?? [];
    }

    /**
     * @param array $pms_reservation
     * @return array
     */
    public function makeCaxReservationInstances(array $pms_reservation=[]): array
    {
        foreach ($pms_reservation as $item) {
            $cax_reservation[] = new HotelReservation(map_pms_keys_to_partner_keys('reservation', $item));
        }

        return $cax_reservation ?? [];
    }
}