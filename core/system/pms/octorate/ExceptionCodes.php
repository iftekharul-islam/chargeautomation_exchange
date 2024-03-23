<?php

const UN_AUTHORIZED = 401;
const ACCESS_DENIED = 403;
const INTERNAL_SERVER_ERROR = 500;

const CAX_EXCEPTION_CODES = [
    UN_AUTHORIZED => CAX_CLIENT_UNAUTHORIZED_ERROR,
    ACCESS_DENIED => CAX_CLIENT_UNAUTHORIZED_ERROR,
    INTERNAL_SERVER_ERROR => PMS_INTERNAL_SERVER_ERROR,
];