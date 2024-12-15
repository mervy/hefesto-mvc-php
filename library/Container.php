<?php
namespace HefestoMVCLibrary;

use Exception;
use ReflectionClass;
use ReflectionNamedType;

class Container
{
    private static $instances = [];

    public static function get(string $class)
    {
        // Verifica se a instância já foi criada
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = self::create($class);
        }

        return self::$instances[$class];
    }

    private static function create(string $class)
    {
        try {
            // Usando Reflection para instanciar a classe com as dependências
            $reflection = new ReflectionClass($class);

            if ($constructor = $reflection->getConstructor()) {
                $dependencies = self::getDependencies($constructor);
                return $reflection->newInstanceArgs($dependencies);
            }

            return new $class;
        } catch (Exception $e) {
            throw new Exception("Não foi possível criar a instância de $class: " . $e->getMessage());
        }
    }

    private static function getDependencies(\ReflectionMethod $constructor)
    {
        $dependencies = [];
        
        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();
            
            // Verifica se o tipo do parâmetro é uma classe (ou interface)
            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = self::get($type->getName()); // Resolve a dependência
            } else {
                // Se o parâmetro não for uma classe, podemos adicionar null ou outro valor padrão
                $dependencies[] = null;
            }
        }

        return $dependencies;
    }
}