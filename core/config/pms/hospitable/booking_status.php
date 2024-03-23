<?php

require_once __DIR__ . '/../../../const/booking_status_const.php';

return [
    //Confirmed booking
    'accepted' => CONFIRMED,
    'awaiting_payment' => CONFIRMED,
    'booking' => CONFIRMED,
    'new' => CONFIRMED,
    'reservation' => CONFIRMED,
    'staying' => CONFIRMED,

    'ACCEPTED' => CONFIRMED,
    'AWAITING_PAYMENT' => CONFIRMED,
    'BOOKING' => CONFIRMED,
    'NEW' => CONFIRMED,
    'RESERVATION' => CONFIRMED,
    'STAYING' => CONFIRMED,


    //Cancelled booking
    'booking_request_withdrawn' => CANCELLED,
    'cancelled' => CANCELLED,
    'canceled' => CANCELLED,
    'declined' => CANCELLED,
    'denied' => CANCELLED,
    'reservation_request_declined' => CANCELLED,
    'reservation_request_expired' => CANCELLED,
    'timeout' => CANCELLED,
    'expired' => CANCELLED,

    'BOOKING_REQUEST_WITHDRAWN' => CANCELLED,
    'CANCELLED' => CANCELLED,
    'CANCELED' => CANCELLED,
    'DECLINED' => CANCELLED,
    'DENIED' => CANCELLED,
    'RESERVATION_REQUEST_DECLINED' => CANCELLED,
    'RESERVATION_REQUEST_EXPIRED' => CANCELLED,
    'TIMEDOUT' => CANCELLED,
    'EXPIRED' => CANCELLED,


    //IGNORED booking
    'post_stay' => IGNORED,
    'blocked_reservation' => IGNORED,
    'cancellation_requested' => CANCELLED,
    'at_checkpoint' => IGNORED,
    'checkpoint' => IGNORED,
    'checkpoint_voided' => IGNORED,
    'checkpoint voided' => IGNORED,
    'inquiry' => REQUEST,
    'payment_request_sent' => IGNORED,
    'pending' => REQUEST,
    'pending_verification' => IGNORED,
    'quote_sent' => IGNORED,
    'replied' => IGNORED,
    'reservation_request' => REQUEST,
    'tentative_reservation' => IGNORED,
    'unknown' => IGNORED,

    'POST_STAY' => IGNORED,
    'BLOCKED_RESERVATION' => IGNORED,
    'CANCELLATION_REQUESTED' => CANCELLED,
    'AT_CHECKPOINT' => IGNORED,
    'CHECKPOINT' => IGNORED,
    'CHECKPOINT_VOIDED' => IGNORED,
    'CHECKPOINT VOIDED' => IGNORED,
    'INQUIRY' => REQUEST,
    'PAYMENT_REQUEST_SENT' => IGNORED,
    'PENDING' => REQUEST,
    'PENDING_VERIFICATION' => IGNORED,
    'QUOTE_SENT' => IGNORED,
    'REPLIED' => IGNORED,
    'RESERVATION_REQUEST' => REQUEST,
    'TENTATIVE_RESERVATION' => IGNORED,
    'UNKNOWN' => IGNORED,

];