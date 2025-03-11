<?php

declare(strict_types=1);

namespace Myposter\Production;

class State
{
    public const ORDERED = 'ordered';
    public const PRINTED = 'printed';
    public const SLICED = 'sliced';
    public const FRAMED = 'framed';
    public const GIFT_WRAPPED = 'gift-wrapped';
    public const SHIPPED = 'shipped';

    private string $state;

    public function __construct(string $state)
    {
        $this->validateState($state);
        $this->state = $state;
    }

    public static function getAllStates(): array
    {
        return [
            self::ORDERED,
            self::PRINTED,
            self::SLICED,
            self::FRAMED,
            self::GIFT_WRAPPED,
            self::SHIPPED
        ];
    }

    private function validateState(string $state): void
    {
        if (!in_array($state, self::getAllStates())) {
            throw new \InvalidArgumentException("Invalid state: {$state}");
        }
    }

    public function getValue(): string
    {
        return $this->state;
    }

    public function equals(State $other): bool
    {
        return $this->state === $other->getValue();
    }
}