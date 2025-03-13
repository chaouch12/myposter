<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Production\State\Framed;
use Myposter\Production\State\GiftWrapped;
use Myposter\Production\State\Ordered;
use Myposter\Production\State\Printed;
use Myposter\Production\State\Shipped;
use Myposter\Production\State\Sliced;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
class FramedPoster extends Article
{
    public function __construct()
    {
        parent::__construct(self::TYPE_POSTER_FRAMED);
    }

    protected function initializeStates(): void
    {
        $this->allowedStateTransitions = [
            Ordered::TYPE,
            Printed::TYPE,
            Sliced::TYPE,
            Framed::TYPE,
        ];

        if ($this->hasGiftWrapping()) {
            $this->allowedStateTransitions[] = GiftWrapped::TYPE;
        }

        $this->allowedStateTransitions[] = Shipped::TYPE;
    }

    public function getAllowedTransitions(): array
    {
        return $this->allowedStateTransitions;
    }
} 