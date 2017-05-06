<?php

namespace Silicates\Bridge\Symfony\Exception;

use Psr\Container\NotFoundExceptionInterface;

/**
 * No entry was found in the container.
 */
class NotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}
