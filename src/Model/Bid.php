<?php

namespace Alura\Leilao\Model;

class Bid
{
    private User $user;
    private float $value;

    public function __construct(User $user, float $value)
    {
        $this->user = $user;
        $this->value = $value;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
