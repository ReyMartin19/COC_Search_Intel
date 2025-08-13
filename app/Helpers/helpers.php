// app/Helpers/helpers.php
<?php

use App\Helpers\LeagueHelper;

if (!function_exists('determine_league')) {
    function determine_league(int $trophies): array
    {
        return LeagueHelper::determineLeague($trophies);
    }
}