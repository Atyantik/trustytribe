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
    protected $header;
    const BASE_URL = "https://beta-api.trustytribe.com/";

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
        $this->header = [
            'header' =>
                [
                    'Authorization' => [
                        'public_api_key' => $this->publicKey,
                        'private_api_key' => $this->privateKey
                    ]
                ]
        ];
    }

    public function getProductReview($productId = null)
    {
        if (isset($productId)) {
            try {
                $result = $this->client->request('GET', self::BASE_URL . 'product/' . $productId . '/review', $this->header);
                return json_decode($result);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return 'Please provide product id';
    }
}