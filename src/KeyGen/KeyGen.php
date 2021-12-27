<?php

namespace src;

class KeyGen
{
    protected $key;
    
    public function __construct()
    {
        $this->key = bin2hex(sodium_crypto_generichash_keygen());
    }
    
    public function __get($name)
    {
        if(isset($this->$name)){
            return $this->$name;
        } else return null;
    }
}