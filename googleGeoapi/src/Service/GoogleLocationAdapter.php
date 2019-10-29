<?php

declare(strict_types=1);


namespace App\Service;

class GoogleLocationAdapter
{
    private $placeLat;
    private $placeLng;
    private $googleApiKey;
    private $googleApiUrl;

    public function __construct()
    {
        $this->googleApiKey = $_ENV['GOOGLE_API_KEY'];
        $this->googleApiUrl = $_ENV['GOOGLE_API_URL'];
    }

    public function getLat(): float
    {
        return $this->placeLat;
    }

    private function setLat(?float $lat): void
    {
        $this->placeLat = $lat;
    }

    public function getLng(): float
    {
        return $this->placeLng;
    }

    private function setLng(?float $lng): void
    {
        $this->placeLng = $lng;
    }

    public function locatePlace(string $place): void
    {
        $apiData = $this->getData($this->buildQuery($place));
        $this->parseResult($apiData);
    }

    private function buildQuery(string $place): string
    {
        $placeElements = explode(' ', $place);
        $queryString = '';
        foreach ($placeElements as $element) {
            $queryString .= $this->parseQueryData($element).'+';
        }
        return rtrim($queryString, '+');
    }

    private function parseQueryData(string $queryData): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $queryData);
    }

    private function getData(string $queryString): string
    {
        $jsonData = file_get_contents($this->googleApiUrl.$queryString.'&key='.$this->googleApiKey);
        return $jsonData;
    }

    private function parseResult(string $jsonData): void
    {
        $decodedData = json_decode($jsonData, true);
        if (!empty($decodedData['results'])) {
            $lat = $decodedData['results'][0]['geometry']['location']['lat'] ?? 0.0;
            $lng = $decodedData['results'][0]['geometry']['location']['lng'] ?? 0.0;
        }
        $this->setLat($lat);
        $this->setLng($lng);
    }
}
