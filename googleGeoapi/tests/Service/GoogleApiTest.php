<?php

declare(strict_types=1);


namespace App\Tests\Service;

use App\Service\GoogleLocationAdapter;
use PHPUnit\Framework\TestCase;

class GoogleApiTest extends TestCase
{
    public function testGoogleApi()
    {
        $place = "Warszawa";
        $placeExpectedLat = 52.2296756;
        $placeExpectedLng = 21.0122287;
        $googleLocationAdapter = new GoogleLocationAdapter();
        $googleLocationAdapter->locatePlace($place);
        $this->assertEquals($placeExpectedLat, $googleLocationAdapter->getLat());
        $this->assertEquals($placeExpectedLng, $googleLocationAdapter->getLng());
    }
}
