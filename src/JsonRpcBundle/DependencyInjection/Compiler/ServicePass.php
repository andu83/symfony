<?php
namespace JsonRpcBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $serverDefinition = $container->findDefinition(\JsonRpcBundle\Server::ID);
        $resolvers        = $container->findTaggedServiceIds('json_rpc.service');
        foreach ($resolvers as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $method = $attributes['method'];
                $serverDefinition->addMethodCall('addAllowedMethod', array($id, $method));
            }
        }
    }
}
