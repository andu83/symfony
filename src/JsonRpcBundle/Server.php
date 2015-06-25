<?php
namespace JsonRpcBundle;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

class Server extends ContainerAware
{
    const ID = 'json_rpc.server';

    public function handle($request, $serviceId)
    {
        $encoder = new JsonEncoder();
        try {
            $request = $encoder->decode($request, JsonEncoder::FORMAT);
        } catch (UnexpectedValueException $exception) {
            return new ErrorResponse(ErrorResponse::ERROR_CODE_PARSE_ERROR, 'Invalid JSON');
        }
        $request = $this->resolveOptions($request);
        if (!$this->isAllowed($serviceId, $request['method'])) {
            return new ErrorResponse(ErrorResponse::ERROR_CODE_METHOD_NOT_FOUND, sprintf('%s does not exist', $request['method']));
        }
        $service = $this->container->get($serviceId);
        $result  = call_user_func_array(array($service, $request['method']), $request['params']);

        return new SuccessResponse($request['id'], $result);
    }

    private function isAllowed($serviceId, $method)
    {
        return true;
    }

    private function resolveOptions($request)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('id')->setRequired('method')->setRequired('jsonrpc')->setDefault('params', array())->addAllowedValues(
            'jsonrpc',
            Response::VERSION
        );

        return $resolver->resolve($request);
    }
}
