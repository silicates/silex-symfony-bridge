<?php

namespace Silicates\Bridge\Symfony\DependencyInjection\ServiceLocator;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 * Pimple service locator that implements the Symfony ContainerInterface.
 */
class SymfonyLocator extends PsrLocator implements ContainerInterface
{
    /**
     * {@inheritdoc}
     */
    public function set($id, $service)
    {
        $this->pimple[$id] = function () use ($service) {
            return $service;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, $invalidBehavior = self::EXCEPTION_ON_INVALID_REFERENCE)
    {
        if ($invalidBehavior === self::EXCEPTION_ON_INVALID_REFERENCE) {
            return parent::get($id);
        }
        try {
            return parent::get($id);
        } catch (ServiceNotFoundException $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function initialized($id)
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException($id);
        }
        $realId = $this->aliases[$id];

        try {
            $this->pimple[$realId] = $this->pimple->raw($realId);
        } catch (\RuntimeException $e) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        return $this->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        return $this->has($name);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        if (isset($this->aliases[$name])) {
            $realName = $this->aliases[$name];
        } else {
            $realName = $this->aliases[$name] = $name;
        }

        $this->pimple[$realName] = is_object($value) && method_exists($value, '__invoke') ? $this->pimple->protect($value) : $value;
    }
}
