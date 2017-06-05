<?php
/**
 * Created by PhpStorm.
 * User: chiragpatel
 * Date: 5/6/17
 * Time: 5:49 PM
 */

namespace Atyantik\Trustytribe;


use GuzzleHttp\Client;

class TrustyTribeManager
{
    protected $privateKey;
    protected $publicKey;
    protected $client;
    z
    public function __construct($privateKey, $publicKey)
    {
        if ($privateKey === null || $privateKey === '') {
            throw new \Exception("Please provide PrivateKey For API");
        }
        if ($publicKey === null || $publicKey === '') {
            throw new \Exception("Please provide PublicKey For API");
        }
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->client = new Client();
    }
}