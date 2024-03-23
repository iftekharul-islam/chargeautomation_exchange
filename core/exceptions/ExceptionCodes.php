<?php

const CAX_INVALID_TYPE = 400;
const CAX_PARTNER_UNAUTHORIZED_ERROR = 401; //10004;

const CAX_VALIDATION_ERROR = 402;
const CAX_ACCESS_DENIED = 403;
const CAX_REQUEST_NOT_SUPPORTED = 404;


const CAX_INTERNAL_SERVER_ERROR = 500;

const CAX_CLIENT_UNAUTHORIZED_ERROR = 1000;
const CAX_INVALID_CREDENTIAL_TOKEN_ERROR = 1001;
const CAX_INVALID_CREDENTIALS_ERROR = 1002;
const CAX_INVALID_PMS = 1003;


const PMS_INTERNAL_SERVER_ERROR = 10005;

const CAX_INVALID_XML_ERROR = 8000;
const CAX_INVALID_JSON_ERROR = 9000;




const CAX_EXCEPTION_MESSAGES = [
    CAX_INVALID_TYPE => 'The Type is not a valid type.',

    CAX_INTERNAL_SERVER_ERROR => 'Internal server error.',
    CAX_CLIENT_UNAUTHORIZED_ERROR => 'Unauthorized.', //PMS Unauthorized credentials
    CAX_PARTNER_UNAUTHORIZED_ERROR => 'Partner API key is not correct.',
    CAX_INVALID_CREDENTIAL_TOKEN_ERROR => 'Credential Token is not correct.',
    CAX_INVALID_CREDENTIALS_ERROR => 'Credentials are not correct.',
    CAX_INVALID_PMS => 'PMS name is not valid.',

    CAX_INVALID_XML_ERROR => 'There is an error parsing the XML.',
    CAX_INVALID_JSON_ERROR => 'There is an error parsing the Json.',

    CAX_REQUEST_NOT_SUPPORTED => 'Request not supported for this PMS.',
    CAX_ACCESS_DENIED => 'Access denied.',

    PMS_INTERNAL_SERVER_ERROR => 'PMS internal server error. Invalid or duplicate request data.'
];

