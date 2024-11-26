<?php

namespace App\Infraestructure\DependencyInjection;

use App\Application\Exceptions\ContainerException;
use DI\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class SimpleContainer implements ContainerInterface
{
    private array $services = [];
    private array $aliases = [];
    private array $invokables = [];

    /**
     * Constructor to initialize the container with configuration
     *
     * @param array $config Configuration with 'invokables' and 'aliases' keys
     */
    public function __construct(array $config = [])
    {
        if (isset($config['invokables'])) {
            foreach ($config['invokables'] as $id => $concrete) {
                $this->invokables[$id] = $concrete;
            }
        }

        // Process aliases
        if (isset($config['aliases'])) {
            foreach ($config['aliases'] as $alias => $original) {
                $this->aliases[$alias] = $original;
            }
        }
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     * @return mixed Entry.
     * @throws NotFoundExceptionInterface  No entry was found for this identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     */
    public function get(string $id)
    {
        $id = $this->aliases[$id] ?? $id;

        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        if (isset($this->invokables[$id])) {
            try {
                if (is_string($this->invokables[$id]) && class_exists($this->invokables[$id])) {
                    $this->services[$id] = new $this->invokables[$id]();
                } else {
                    $this->services[$id] = $this->invokables[$id];
                }
                return $this->services[$id];
            } catch (\Throwable $e) {
                throw new ContainerException("Error creating service: " . $e->getMessage(), 0, $e);
            }
        }

        throw new NotFoundException("No entry was found for '$id'");
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     *
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        // Resolve alias
        $id = $this->aliases[$id] ?? $id;

        return
            isset($this->services[$id]) ||
            isset($this->invokables[$id]);
    }

    /**
     * Add a new invokable to the container
     *
     * @param string $id Identifier for the service
     * @param mixed $concrete The service or class to instantiate
     */
    public function addInvokable(string $id, $concrete)
    {
        $this->invokables[$id] = $concrete;
    }

    /**
     * Add a new alias
     *
     * @param string $alias Alias name
     * @param string $original Original service identifier
     */
    public function addAlias(string $alias, string $original)
    {
        $this->aliases[$alias] = $original;
    }
}
