<?php

require_once __DIR__ . '/../../../const/booking_status_const.php';

return [
    'active' => CONFIRMED,
    'canceled' => CANCELLED,
    'pending' => REQUEST,
    'block' => BLOCKED,
];