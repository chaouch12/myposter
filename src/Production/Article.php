<?php

declare(strict_types=1);

namespace Myposter\Production;

abstract class Article
{
	public const TYPE_POSTER_FRAMED = 'poster-framed';
	public const TYPE_PRINTED_GLASS = 'printed-glass';

	private string $articleType;
    private int $currentStateIndex;

    /**
     * @var string[]
     */
    protected array $allowedStateTransitions = [];
	protected bool $hasGiftWrapping = false;

	/**
	 * @throws \InvalidArgumentException Unknown article type
	 */
	public function __construct(string $articleType)
	{
		self::validateType($articleType);
		$this->articleType = $articleType;
        $this->initializeStates();
        $this->currentStateIndex = 0;
	}

    abstract protected function initializeStates(): void;
    abstract public function getAllowedTransitions(): array;

	/**
	 * @return string[]
	 */
	public static function getTypes(): array
	{
		return [
			self::TYPE_POSTER_FRAMED,
			self::TYPE_PRINTED_GLASS,
		];
	}

	private static function isTypeValid(string $articleType): bool
	{
		return \in_array($articleType, self::getTypes());
	}

	/**
	 * @throws \InvalidArgumentException Unknown article type
	 */
	private static function validateType(string $articleType): void
	{
		if (! self::isTypeValid($articleType)) {
			throw new \InvalidArgumentException('unknown article type given: ' . $articleType, 1626963396724);
		}
	}

	/**
	 * @return $this
	 */
	public function enableGiftWrapping(): self
	{
		$this->hasGiftWrapping = true;
        $this->initializeStates();
		return $this;
	}

	public function hasGiftWrapping(): bool
	{
		return $this->hasGiftWrapping;
	}

	public function getType(): string
	{
		return $this->articleType;
	}

    public function getAllowedStateTransitions(): array
    {
        return $this->allowedStateTransitions;
    }

    public function getCurrentStateIndex(): int
    {
        return $this->currentStateIndex;
    }

    public function incrementCurrentStateIndex(): void
    {
        ++$this->currentStateIndex;
    }
}
