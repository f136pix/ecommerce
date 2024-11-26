<?php

namespace App\Application\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class NotFoundDependencyException extends Exception implements NotFoundExceptionInterface
{
}
