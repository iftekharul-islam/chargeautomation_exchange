<?php
require_once __DIR__ . '/../core/includes/autoload.php';
require_once __DIR__ . '/../core/DB.php';

if (!function_exists('storeWebhookLogs')) {
    function storeWebhookLogs($partner_user, $pms_response, $cax_response, $partner_user_response, $status, $attempt)
    {
        DB::executeQueryForLog('INSERT INTO `webhook_logs`(`partner_id`, `partner_user_id`, `pms_name`, `url`, `pms_response`, `cax_response`, `partner_user_response`, `attempt`, `status`)
                VALUES (:partner_id, :partner_user_id, :pms_name, :url, :pms_response, :cax_response, :partner_user_response, :attempt, :status)',
            [
                "partner_id"=>$partner_user['partner_id'],
                "partner_user_id"=>$partner_user['id'],
                "pms_name"=>$partner_user['pms_name'],
                "url"=>$partner_user['url'],
                "pms_response"=>$pms_response,
                "cax_response"=>$cax_response,
                "partner_user_response"=>$partner_user_response,
                "attempt"=>$attempt,
                "status"=>$status
            ]
        );
    }
}

if (!function_exists('storeWebhookAttempt')) {
    function storeWebhookAttempt($partner_user, $pms_response, $cax_response, $id=0)
    {
        DB::executeStatement('INSERT INTO `webhooks`(`partner_id`, `partner_user_id`, `url`, `attempt`)
                VALUES (:partner_id, :partner_user_id, :url, :attempt)',
            [
                "partner_id"=> $partner_user['partner_id'],
                "partner_user_id"=>$partner_user['id'],
                "url"=>$partner_user['url'],
                "attempt"=>1
            ]
        );

        $webhook_id = DB::getConnection()->lastInsertId();

        DB::executeStatement('INSERT INTO `webhook_details`(`webhook_id`, `pms_response`, `cax_response`)
                VALUES (:webhook_id, :pms_response, :cax_response)',
            [
                "webhook_id"=> $webhook_id,
                "pms_response"=>$pms_response,
                "cax_response"=>$cax_response
            ]
        );
        return $webhook_id;
    }
}