<?php

namespace Core\System\pms\hostify;

trait PMS_Helper
{
    /**
     * @return array
     */
    public function setHeaders(): array
    {
        return ['Content-Type' => 'application/json'];
    }

    /**
     * @throws \CaxException
     */
    public function setAuth()
    {
        $credentials = getUserCredentials();

        if (empty($credentials['api_key'])) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
        }

        $this->headers['x-api-key'] = $credentials['api_key'];
    }

    private function filterPMSEnabledWebhook(array $pms_webhooks, $webhook_type, $webhook_url)
    {
        foreach ($pms_webhooks as $pms_webhook) {
            if ($pms_webhook['type'] == $webhook_type && $pms_webhook['url'] == $webhook_url) {
                return $pms_webhook;
            }
        }

        return null;
    }
}

?>