<?php
namespace Core\System\pms\hostastay;

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
        }

        $this->headers['Access-Token'] =  $credentials['access_token'];
        $this->headers['property_id'] = $credentials['property_id']??null;
    }
}
?>