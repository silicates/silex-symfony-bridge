<?php

namespace Silicates\Bridge\Symfony\DependencyInjection\ServiceLocator;

use Pimple\Container;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

/**
 * Pimple service locator that implements the PSR-11 ContainerInterface.
 */
class PsrLocator implements ContainerInterface
{
    protected $pimple;
    protected $aliases;

    /**
     * Creates a PsrLocator for a ServiceSubscriberInterface class.
     *
     * @param Container $pimple
     * @param string    $subscriberClass
     *
     * @return static
     */
    public static function fromServiceSubscriber(Container $pimple, $subscriberClass)
    {
        if (!$subscriberClass instanceof ServiceSubscriberInterface) {
            throw new \LogicException(sprintf('The class %s does not implement %s.', $subscriberClass, ServiceSubscriberInterface::class));
        }
        $subscribedServices = $subscriberClass::getSubscribedServices();

        $aliases = [];
        foreach ($subscribedServices as $alias => $id) {
            $required = true;
            if (isset($id[0]) && '?' === $id[0]) {
                $required = false;
                $id = substr($id, 1);
            }
            if ($required && !isset($pimple[$id])) {
                throw new ServiceNotFoundException($id);
            }
            $aliases[$alias] = $id;
        }

        return new static($pimple, $aliases);
    }

    /**
     * Constructor.
     *
     * @param Container $pimple  The Pimple container to use to locate entries
     * @param array     $aliases
     */
    public function __construct(Container $pimple, array $aliases = [])
    {
        $this->pimple = $pimple;
        $this->aliases = $aliases;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (!isset($this->aliases[$id]) || !isset($this->pimple[$realId = $this->aliases[$id]])) {
            throw new ServiceNotFoundException($id);
        }

        return $this->pimple[$realId];
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        if (!isset($this->aliases[$id])) {
            return false;
        }

        return isset($this->pimple[$this->aliases[$id]]);
    }
}
