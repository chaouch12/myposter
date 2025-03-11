<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Production\State\StateInterface;

abstract class Article
{
	public const TYPE_POSTER_FRAMED = 'poster-framed';
	public const TYPE_PRINTED_GLASS = 'printed-glass';

	private string $articleType;
	private StateInterface $state;

    /**
     * @var StateInterface[]
     */
    protected array $stateTransitions = [];
	protected bool $hasGiftWrapping = false;

	/**
	 * @throws \InvalidArgumentException Unknown article type
	 */
	public function __construct(string $articleType, StateInterface $initialState)
	{
		self::validateType($articleType);
		$this->articleType = $articleType;
		$this->state = $initialState;
        $this->initializeStates();
	}

    abstract protected function initializeStates(): void;

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

	public function getState(): StateInterface
	{
		return $this->state;
	}

	public function setState(StateInterface $state): void
	{
		$this->state = $state;
	}

	/**
	 * @return $this
	 */
	public function enableGiftWrapping(): self
	{
		$this->hasGiftWrapping = true;
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

    public function getStateTransitions(): array
    {
        return $this->stateTransitions;
    }
}
