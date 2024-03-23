<?php
namespace Core\System\pms\wubook;

trait PMS_Helper
{
    /**
     * @return array
     */
    public function setHeaders(): array
    {
        return [];
    }

    /**
     * @throws \CaxException
     */
    public function setAuth()
    {
        $credentials = getUserCredentials();

        if (empty($credentials['access_token'])) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
        } elseif ($credentials['expires_in'] <= time()) {
            $this->make_auth();

            $credentials = getUserCredentials();
        }

        $this->headers['Authorization'] = 'Bearer ' . $credentials['access_token'] ?? null;
    }
}
?>