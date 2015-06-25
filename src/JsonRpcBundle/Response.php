<?php
namespace JsonRpcBundle;

abstract class Response
{
    const VERSION = '2.0';
    private $id;
    private $jsonrpc = self::VERSION;
    private $resultKey;
    private $result;

    public function __construct($id, $resultKey, $result)
    {
        $this->id        = $id;
        $this->resultKey = $resultKey;
        $this->result    = $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getJsonrpc()
    {
        return $this->jsonrpc;
    }

    public function getResultKey()
    {
        return $this->resultKey;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setJsonrpc($jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;

        return $this;
    }

    public function setResultKey($resultKey)
    {
        $this->resultKey = $resultKey;

        return $this;
    }

    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    public function toArray()
    {
        return array('id' => $this->getId(), 'jsonrpc' => $this->getJsonrpc(), $this->getResultKey() => $this->getResult());
    }
}
