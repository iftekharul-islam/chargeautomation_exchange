<?php

require_once __DIR__ . '/../../../const/booking_status_const.php';

/**
 * Here are brief explanations of each:
 *
 * Accepted: The booking has been confirmed by the host.
 * Pending: The booking request is still being processed by the host.
 * Denied: The host has declined the booking request.
 * Cancelled: The booking has been cancelled by either the host or the guest.
 * No_show: The guest did not show up for the booking.
 * Awaiting_payment: The booking is awaiting payment from the guest.
 * Moved: The booking has been moved to a different date or location.
 * Extended: The booking has been extended to a later date.
 * Edited: The booking details have been modified.
 * Retracted: The booking request has been withdrawn by the guest.
 * Inquiry: The guest has sent an inquiry to the host but has not yet requested to book.
 * Declined_inq: The host has declined the inquiry from the guest.
 * Preapproved: The host has pre-approved the guest's booking request.
 * Offer: The host has made a special offer to the guest.
 * Withdrawn: The host has withdrawn their offer or pre-approval.
 * Expired: The booking request or offer has expired.
 * Timedout: The booking process has timed out due to inactivity.
 * Not_possible: The booking request cannot be accommodated by the host.
 * New: The booking is a new request.
 * Deleted: The booking has been deleted from the system.
 */
return [

    'inquiry' => INQUIRY,
    'not_possible' => INQUIRY,

    'new' => ACTIVE,
    'no_show' => ACTIVE,
    'pending' => PENDING,
    'awaiting_payment' => ACTIVE,
    'accepted' => ACTIVE,
    'moved' => ACTIVE,
    'extended' => ACTIVE,
    'edited' => ACTIVE,
    'preapproved' => ACTIVE,
    'offer' => ACTIVE,
    'timedout' => ACTIVE,

    'withdrawn' => CANCELED,
    'deleted' => CANCELED,
    'expired' => CANCELED,
    'denied' => CANCELED,
    'cancelled' => CANCELED,
    'retracted' => CANCELED,
    'declined_inq' => CANCELED,
    'voided' => CANCELED,
];