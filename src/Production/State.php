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
}