<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;

abstract class RequestObject
{
    private array $originalData {
        get {
            return $this->originalData;
        }
    }

    public static function fromRequest(FormRequest $request): static
    {
        $instance = new static();

        $types = $instance->types();

        $data = $request->validated();

        $instance->originalData = $data;

        foreach ($types as $key => $type) {
            $value = $data[$key] ?? null;

            if (is_array($type)) {
                $castedValue = self::processClassCasting($type, $value);
            } elseif (is_string($type)) {
                [$baseType, $default] = self::wannaDefaultValue($type);

                $castedValue = self::processBasicCasting($value, $baseType, $default);
            } else {
                throw new InvalidArgumentException("Invalid type for key: $key");
            }

            $instance->{$key} = $castedValue;
        }

        return $instance;
    }

    private static function wannaDefaultValue(string $type): array
    {
        $segments = explode('#', $type);

        $baseType = $segments[0];

        $default = $segments[1] ?? null;

        return [$baseType, $default];
    }

    private static function processClassCasting(array $type, mixed $value): mixed
    {
        [$class, $method] = $type;

        if (!method_exists($class, $method)) {
            throw new InvalidArgumentException("Method $class::$method does not exist");
        }

        return $class::$method($value);
    }

    private static function processBasicCasting(mixed $value, string $type, mixed $default = null): mixed
    {
        if (is_null($value)) {
            return $default ?? null;
        }

        return match ($type) {
            'string' => (string)$value,
            'int'    => (int)$value,
            'float'  => (float)$value,
            'bool'   => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'array'  => (array)$value,
            default  => throw new \InvalidArgumentException("Unknown basic type: $type"),
        };
    }

    abstract public function types(): array;
}