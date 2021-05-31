<?php

namespace App\Discounts;

final class DiscountResult
{
    private $discountReason;
    private $discountAmount;
    private $subtotal;

    public function __construct(string $discountReason, float $discountAmount, float $subtotal)
    {
        $this->discountReason = $discountReason;
        $this->discountAmount = $discountAmount;
        $this->subtotal = $subtotal;
    }

    /**
     * Returns array formatted discount result
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'reason' => $this->discountReason,
            'amount' => formatFloat($this->discountAmount),
            'subtotal' => formatFloat($this->subtotal),
        ];
    }
}
