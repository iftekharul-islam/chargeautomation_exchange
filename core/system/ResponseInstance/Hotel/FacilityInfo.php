<?php

namespace Core\System\ResponseInstance\Hotel;

use Core\System\ResponseInstance\SetClassAttribute;

class FacilityInfo
{
    use SetClassAttribute;

    public array $HotelRooms = [
        'TotalRooms' => null,
        'HotelRoom' => [], //Array of Hotel/Room
    ];

    public array $HotelUnits = [
        'TotalUnits' => null,
        'HotelUnit' => [], //Array of Hotel/Unit
    ];

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->setAttributes($data);
        $this->setHotelRooms($this->HotelUnits['HotelRoom'] ?? []);
        $this->setHotelUnits($this->HotelUnits['HotelUnit'] ?? []);
    }

    /**
     * @param array $HotelUnits
     */
    public function setHotelUnits(array $HotelUnits): void
    {
        if (!empty($this->HotelUnits['HotelUnit'])) {

            $units = [];

            foreach ($this->HotelUnits['HotelUnit'] as $unit) {
                $units[] = new Unit($unit);
            }

            $this->HotelUnits['HotelUnit'] = $units;
            $this->HotelUnits['TotalUnits'] = count($units);
        }
    }

    /**
     * @param array $HotelRooms
     */
    private function setHotelRooms(array $HotelRooms): void
    {
        if (!empty($this->HotelRooms['HotelRoom'])) {

            $rooms = [];

            foreach ($this->HotelRooms['HotelRoom'] as $room) {
                $rooms[] = new Room($room);
            }

            $this->HotelRooms['HotelRoom'] = $rooms;
            $this->HotelRooms['TotalRooms'] = count($rooms);
        }
    }
}