<?php

// src/Service/FruitService.php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FruitService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getAllFruits()
    {
        $response = $this->httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');
        $content = $response->getContent();
        $fruits = json_decode($content, true);
        return $fruits;
    }
}
