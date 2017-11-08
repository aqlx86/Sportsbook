<?php

namespace SportsBook\ValueObject;

use SportsBook\Exception;

class Secret
{
    protected $secret;

    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    public function is_valid($key, $seq)
    {
        $valid = $this->secret == md5($key . $seq);

        if (! $valid)
            throw new Exception\InvalidSecretHashException('invalid secret hash');

        return $valid;
    }
}