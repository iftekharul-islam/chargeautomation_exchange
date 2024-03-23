<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/../DB.php';
$http_headers = getallheaders();
$global_partner = $global_partner_user = [];
require_once __DIR__ . '/set_global_variable.php';
require_once __DIR__ . '/get_partner_and_partner_user_globally.php';
require_once __DIR__ . '/../../helpers/manifest_global_helper.php';
require_once __DIR__ . '/../exceptions/CaxException.php';
require_once __DIR__ . '/../const/pms_info_const.php';
