<?php

namespace src;

class HMACGen extends KeyGen
{
    protected $hmac;
    
    public function __construct($computerMove)
    {
        KeyGen::__construct();
        $this->hmac = hash_hmac('sha3-256', (string)$computerMove, $this->key);
    }
}