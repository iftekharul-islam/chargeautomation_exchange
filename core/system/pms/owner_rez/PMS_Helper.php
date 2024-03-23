<?php


namespace Core\System\pms\owner_rez;


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
        $access_token = $credentials['access_token'];
        if (empty($access_token)) {
            throwException(CAX_EXCEPTION_MESSAGES[CAX_CLIENT_UNAUTHORIZED_ERROR], CAX_CLIENT_UNAUTHORIZED_ERROR);
        }

        //$this->headers['Authorization'] = 'Bearer at_ja54qle1rrfzs0lravla51gfb5dh1526';//TODO::Remove
        $this->headers['Authorization'] = 'Bearer '. $access_token;
    }
}