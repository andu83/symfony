<?php
namespace JsonRpcBundle;

class SuccessResponse extends Response
{
    public function __construct($id, $result)
    {
        parent::__construct($id, 'result', $result);
    }
}