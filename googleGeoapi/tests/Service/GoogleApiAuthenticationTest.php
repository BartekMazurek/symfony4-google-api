<?php

declare(strict_types=1);


namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;

class GoogleApiAuthenticationTest extends TestCase
{
    public function testGoogleApiKey()
    {
        $googleApiKey = $_ENV['GOOGLE_API_KEY'];
        $this->assertNotNull($googleApiKey);
    }

    public function testGoogleUrl()
    {
        $googleUrl = $_ENV['GOOGLE_API_URL'];
        $this->assertNotNull($googleUrl);
    }

    public function testGoogleApiResponse()
    {
        $googleApiKey = $_ENV['GOOGLE_API_KEY'];
        $googleUrl = $_ENV['GOOGLE_API_URL'];
        $location = "Warszawa";
        $data = file_get_contents($googleUrl.$location.'&key='.$googleApiKey);
        $decodedData = json_decode($data, true);
        $this->assertEquals('OK', $decodedData['status']);
    }
}
