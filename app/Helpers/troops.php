// app/Helpers/troops.php
<?php

use App\Services\TroopService;

if (!function_exists('get_troop_data')) {
    function get_troop_data(array $playerData): array
    {
        return app(TroopService::class)->processTroopData($playerData);
    }
}

if (!function_exists('format_troop_image_name')) {
    function format_troop_image_name(string $troopName): string
    {
        return app(TroopService::class)->formatImageName($troopName);
    }
}