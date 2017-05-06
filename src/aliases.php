<?php

use Silicates\Bridge\Symfony\DependencyInjection\ContainerAwareInterface;
use Silicates\Bridge\Symfony\DependencyInjection\ContainerAwareTrait;
use Silicates\Bridge\Symfony\DependencyInjection\ContainerInterface;
use Silicates\Bridge\Symfony\DependencyInjection\Exception\ExceptionInterface;
use Silicates\Bridge\Symfony\DependencyInjection\Exception\InvalidArgumentException;
use Silicates\Bridge\Symfony\DependencyInjection\Exception\RuntimeException;
use Silicates\Bridge\Symfony\DependencyInjection\Exception\ServiceCircularReferenceException;
use Silicates\Bridge\Symfony\DependencyInjection\Exception\ServiceNotFoundException;
use Silicates\Bridge\Symfony\DependencyInjection\ServiceSubscriberInterface;

class_alias(ContainerAwareInterface::class, 'Symfony\Component\DependencyInjection\ContainerAwareInterface', false);
class_alias(ContainerAwareTrait::class, 'Symfony\Component\DependencyInjection\ContainerAwareTrait', false);
class_alias(ContainerInterface::class, 'Symfony\Component\DependencyInjection\ContainerInterface', false);
class_alias(ExceptionInterface::class, 'Symfony\Component\DependencyInjection\Exception\ExceptionInterface', false);
class_alias(InvalidArgumentException::class, 'Symfony\Component\DependencyInjection\Exception\InvalidArgumentException', false);
class_alias(RuntimeException::class, 'Symfony\Component\DependencyInjection\Exception\RuntimeException', false);
class_alias(ServiceCircularReferenceException::class, 'Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException', false);
class_alias(ServiceNotFoundException::class, 'Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException', false);
class_alias(ServiceSubscriberInterface::class, 'Symfony\Component\DependencyInjection\ServiceSubscriberInterface', false);
