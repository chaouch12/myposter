<?php

declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Production\State\GiftWrapped;
use Myposter\Production\State\Ordered;
use Myposter\Production\State\Printed;
use Myposter\Production\State\Shipped;

/**
 * @author Walid Chaouch <walid.chaouch500@gmail.com>
 */
class GlassPlate extends Article
{
    public function __construct()
    {
        parent::__construct(self::TYPE_PRINTED_GLASS);
    }

    protected function initializeStates(): void
    {
        $this->allowedStateTransitions = [
            Ordered::TYPE,
            Printed::TYPE,
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