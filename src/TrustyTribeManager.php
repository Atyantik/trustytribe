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
    const SANDBOX_API_URL = 'https://beta-api.trustytribe.com/';
    const LIVE_API_URL = 'https://api.trustytribe.com/';
    protected $privateKey;
    protected $publicKey;
    protected $client;
    protected $header;

    public function __construct($publicKey, $privateKey, $sandBox = true)
    {
        if ($privateKey === null || $privateKey === '') {
            throw new \Exception("Please provide PrivateKey For API");
        }
        if ($publicKey === null || $publicKey === '') {
            throw new \Exception("Please provide PublicKey For API");
        }
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $baseUrl = self::LIVE_API_URL;
        if ($sandBox === true) {
            $baseUrl = self::SANDBOX_API_URL;
        }
        $this->client = new Client(['base_uri' => $baseUrl, 'headers' => [
            'Authorization' => $this->generateAuturozationKey()
        ]]);
    }

    private function generateAuturozationKey()
    {
        return $this->publicKey . '::' . $this->privateKey;
    }

    public function getProductAggregateReview($productId = null)
    {
        if (isset($productId)) {
            try {
                $result = $this->client->request('GET', "product/$productId/aggregate-review");
                return json_decode($result->getBody()->getContents(), true);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        throw new \Exception('Please provide product id');
    }

    public function getReviews($filters = [])
    {
        try {
            $result = $this->client->request('GET', "review", [
                'query' => $filters
            ]);
            return json_decode($result->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAggregatedReviews($filters = [])
    {
        try {
            $result = $this->client->request('GET', "review/aggregated-reviews", [
                'query' => $filters
            ]);
            return json_decode($result->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}