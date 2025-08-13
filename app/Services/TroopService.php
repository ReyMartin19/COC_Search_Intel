<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TroopService
{
    public const ELIXIR_TROOPS = [
        'Barbarian', 'Archer', 'Giant', 'Goblin', 'Wall Breaker', 'Balloon', 'Wizard',
        'Healer', 'Dragon', 'P.E.K.K.A', 'Baby Dragon', 'Miner', 'Electro Dragon',
        'Yeti', 'Dragon Rider', 'Electro Titan', 'Root Rider', 'Thrower'
    ];

    public const DARK_TROOPS = [
        'Minion', 'Hog Rider', 'Valkyrie', 'Golem', 'Witch', 'Lava Hound', 'Bowler',
        'Ice Golem', 'Headhunter', 'Apprentice Warden', 'Druid', 'Furnace'
    ];

    public const SUPER_TROOPS = [
        'Super Barbarian', 'Super Archer', 'Super Giant', 'Sneaky Goblin', 'Super Wall Breaker',
        'Rocket Balloon', 'Super Wizard', 'Super Dragon', 'Inferno Dragon', 'Super Miner',
        'Super Yeti', 'Super Minion', 'Super Hog Rider', 'Super Valkyrie',
        'Super Witch', 'Ice Hound', 'Super Bowler'
    ];

    public const BUILDER_BASE_TROOPS = [
        'Raged Barbarian', 'Sneaky Archer', 'Boxer Giant', 'Beta Minion', 'Bomber',
        'Baby Dragon', 'Cannon Cart', 'Night Witch', 'Drop Ship', 'Power P.E.K.K.A',
        'Hog Glider', 'Electrofire Wizard'
    ];

    public const SIEGE_MACHINES = [
        'Wall Wrecker', 'Battle Blimp', 'Stone Slammer', 'Siege Barracks',
        'Log Launcher', 'Flame Flinger', 'Battle Drill', 'Troop Launcher'
    ];

    public const HERO_PETS = [
        'L.A.S.S.I', 'Electro Owl', 'Mighty Yak', 'Unicorn',
        'Frosty', 'Diggy', 'Poison Lizard', 'Phoenix',
        'Spirit Fox', 'Angry Jelly', 'Sneezy'
    ];

    public function getGroupedTroops(): array
    {
        return [
            'Elixir Troops' => self::ELIXIR_TROOPS,
            'Dark Elixir Troops' => self::DARK_TROOPS,
            'Super Troops' => self::SUPER_TROOPS,
            'Builder Base Troops' => self::BUILDER_BASE_TROOPS,
            'Siege Machines' => self::SIEGE_MACHINES,
            'Hero Pets' => self::HERO_PETS,
        ];
    }

    public function getCategoryFolders(): array
    {
        return [
            'Elixir Troops' => 'TH/E_Troops',
            'Dark Elixir Troops' => 'TH/DE_Troops',
            'Super Troops' => 'TH/Super_Troops',
            'Builder Base Troops' => 'TH/BH_Troops',
            'Siege Machines' => 'TH/Siege_Machine',
            'Hero Pets' => 'TH/Pets',
        ];
    }

    public function processTroopData(array $playerData): array
    {
        $allTroops = collect($playerData['troops'] ?? []);
        
        // Extract hero pets from troops if heroPets array is missing
        $playerPets = collect($playerData['heroPets'] ?? [])
            ->when(empty($playerData['heroPets']), function ($collection) use ($allTroops) {
                return $allTroops->filter(fn($troop) => in_array($troop['name'], self::HERO_PETS));
            });

        $playerTroops = $allTroops->reject(fn($troop) => in_array($troop['name'], self::HERO_PETS));

        return [
            'groupedTroops' => $this->getGroupedTroops(),
            'categoryFolders' => $this->getCategoryFolders(),
            'playerTroops' => $playerTroops,
            'playerPets' => $playerPets,
        ];
    }

    public function formatImageName(string $troopName): string
    {
        return 'Avatar_' . str_replace([' ', '.', '(', ')'], ['_', '', '', ''], $troopName) . '.webp';
    }
}