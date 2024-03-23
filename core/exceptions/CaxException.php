<?php

class CaxException extends Exception
{
    /**
     * @var string[]
     */
    public $messages;
    private array $data;

    /**
     * @var array|mixed
     */
    private $pms_exception_codes;

    public function __construct($message = "", $code = 0, Throwable $previous = null, $data = [])
    {
        parent::__construct($message, $code, $previous);
        $this->messages = CAX_EXCEPTION_MESSAGES;
        $message = $this->messages[$code] ?? $message;

        $this->data = $data;

        $this->insertExceptionLog($code, $message, $previous);
        $this->pms_exception_codes = getCAX_PMSExceptionCodes();
    }

    /**
     * @return mixed
     */
    public function getCaxDefinedCode()
    {
       return $this->pms_exception_codes[$this->code] ?? $this->code;
    }

    /**
     * @return mixed
     */
    public function getCaxDefinedMessage()
    {
        if(isset($this->pms_exception_codes[$this->code])
            && isset($this->messages[$this->pms_exception_codes[$this->code]])) {
           return  $this->messages[$this->pms_exception_codes[$this->code]];
        }

        return $this->messages[$this->code] ?? $this->getMessage();
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function constructErrorResponse($statusCode, $title, $detail): array
    {
        // Set timestamp to New York
        $timestamp = (new DateTime("America/New_York"))->format("Y-m-d h:i:s ") . "EST";

        return [
            "error" => [
                "timestamp" => $timestamp,
                "status" => $statusCode,
                "title" => $title,
                "detail" => $detail,
                "url" => $_SERVER['REQUEST_URI'],
            ],
        ];
    }

    public function insertExceptionLog($exception_code, $exception_message, $previous)
    {
        $stack_trace = $previous ? $previous->getTraceAsString() : $this->getTraceAsString();
        DB::executeQueryForLog('INSERT INTO `exception_logs` (`partner_id`, `partner_user_id`, `exception_code`, `exception_message`, `stack_trace`, `request_url`, `extra_data`) 
            VALUES (:partner_id, :partner_user_id, :exception_code, :exception_message, :stack_trace, :request_url, :extra_data)',
            [
                'partner_id' => getPartnerId()?:null,
                'partner_user_id' => getPartnerUserId()?:null,
                'exception_code' => $exception_code,
                'exception_message' => $exception_message,
                'stack_trace' => $stack_trace,
                'request_url' => $_SERVER['REQUEST_URI']?:'',
                'extra_data' => json_encode($this->data)
            ]
        );
    }
}