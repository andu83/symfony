<?php
namespace JsonRpcBundle;

class ErrorResponse extends Response
{
    const ERROR_CODE_PARSE_ERROR = -32700;
    const ERROR_CODE_METHOD_NOT_FOUND = -32601;
    const ERROR_CODE_SERVER_ERROR = -32000;

    public function __construct($code, $message, $id = null)
    {
        parent::__construct($id, 'error', array('code' => $code, 'message' => $message));
    }
}
