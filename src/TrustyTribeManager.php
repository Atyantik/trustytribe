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
    const API_URL = 'https://beta-api.trustytribe.com/';
    protected $privateKey;
    protected $publicKey;
    protected $client;
    protected $header;

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

        $this->client = new Client(['base_uri' => self::API_URL]);
        $this->header = [
            'header' => [
                'Authorization' => $this->generateAuturozationKey()
            ]
        ];
    }

    private function generateAuturozationKey()
    {
        return $this->publicKey . '::' . $this->privateKey;
    }

    public function getProductReview($productId = null)
    {
        if (isset($productId)) {
            try {
                $result = $this->client->request('GET', "product/$productId/review");
                return json_decode($result->getBody()->getContents());
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        throw new \Exception('Please provide product id');
    }

    public function getProductAggregateReview($productId = null)
    {
        if (isset($productId)) {
            try {
                $result = $this->client->request('GET', "product/$productId/aggregate-review");
                return json_decode($result->getBody()->getContents());
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        throw new \Exception('Please provide product id');
    }
}