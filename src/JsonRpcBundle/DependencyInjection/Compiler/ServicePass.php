<?php
namespace JsonRpcBundle\DependencyInjection\Compiler;

use JsonRpcBundle\Server;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use JsonRpcBundle\Exception\InvalidMethodException;

class ServicePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $serverDefinition = $container->findDefinition(Server::ID);
        $resolvers        = $container->findTaggedServiceIds('json_rpc.service');
        foreach ($resolvers as $id => $tags) {
            $this->registerMethods($container, $serverDefinition, $id, $tags);
            foreach ($container->getAliases() as $aliasName => $alias) {
                if ($alias->isPublic() && (string)$alias === $id) {
                    $this->registerMethods($container, $serverDefinition, $aliasName, $tags);
                }
            }
        }
    }

    private function registerMethods(ContainerBuilder $container, Definition $server, $serviceId, $tags)
    {
        $class = $container->findDefinition($serviceId)->getClass();
        foreach ($tags as $tag) {
            $method = $tag['method'];
            if (!is_callable(array($class, $method))) {
                throw new InvalidMethodException(sprintf('%s::%s is not callable', $class, $method));
            }
            $server->addMethodCall('addAllowedMethod', array($serviceId, $method));
        }
    }
}
