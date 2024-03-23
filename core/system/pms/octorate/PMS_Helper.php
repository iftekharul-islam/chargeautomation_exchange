<?php
namespace Core\System\pms\octorate;

use DateTime;
use DateTimeZone;

trait PMS_Helper
{
    /**
     * @return array
     */
    public function setHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    /**
     * @throws \CaxException
     * @throws \Exception
     */
    public function setAuth()
    {
        $credentials = getUserCredentials();

        if (empty($credentials['access_token'])) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
        }

        $dateTime = new DateTime(str_replace('[UTC]', '',$credentials['expireDate']));
        $dateTime->setTimezone(new DateTimeZone('GMT'));

        //TODO::403::retry
        if ($dateTime->getTimestamp() <= (time()+60)) {
            $this->make_auth(); //Refresh oAuth
            $credentials = getUserCredentials();
        }

        $this->headers['Authorization'] = 'Bearer '.$credentials['access_token'] ?? null;
    }

    /**
     * @param array $pms_webhooks
     * @param $webhook_type
     * @param $webhook_url
     * @param false $skip_url_check
     * @return mixed|null
     */
    private function filterPMSEnabledWebhook(array $pms_webhooks, $webhook_type, $webhook_url, $skip_url_check=false)
    {
        foreach ($pms_webhooks as $pms_webhook) {
            if ($pms_webhook['type'] == $webhook_type && ($skip_url_check || $pms_webhook['endpoint'] == $webhook_url)) {
                return $pms_webhook;
            }
        }

        return null;
    }
}
?>