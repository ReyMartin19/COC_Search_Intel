<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PlayerController extends Controller
{
    public function index()
    {
        $base = 'https://api.clashofclans.com/v1/locations/global/rankings';
        $token = env('COC_API_TOKEN');

        $homeVillageTop = Cache::remember('homeVillageTop', 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/players", ['limit' => 5]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $builderBaseTop = Cache::remember('builderBaseTop', 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/players-builder-base", ['limit' => 5]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $homeClanTop = Cache::remember('homeClanTop', 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/clans", ['limit' => 5]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $builderClanTop = Cache::remember('builderClanTop', 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/clans-builder-base", ['limit' => 5]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $capitalClanTop = Cache::remember('capitalClanTop', 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/capitals", ['limit' => 5]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        return view('index', compact('homeVillageTop', 'builderBaseTop', 'homeClanTop', 'builderClanTop', 'capitalClanTop'));
    }

    public function rankings(Request $request)
    {
        $token = env('COC_API_TOKEN');
        $locationId = $request->input('locationId', 'global');
        $base = "https://api.clashofclans.com/v1/locations/{$locationId}/rankings";

        // Fetch locations for the filter
        $locations = Cache::remember('coc_locations', 86400, function () use ($token) {
            $res = Http::withToken($token)->get('https://api.clashofclans.com/v1/locations');
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $homeVillageTop = Cache::remember("homeVillageTop_50_{$locationId}", 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/players", ['limit' => 50]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $builderBaseTop = Cache::remember("builderBaseTop_50_{$locationId}", 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/players-builder-base", ['limit' => 50]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $homeClanTop = Cache::remember("homeClanTop_50_{$locationId}", 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/clans", ['limit' => 50]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $builderClanTop = Cache::remember("builderClanTop_50_{$locationId}", 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/clans-builder-base", ['limit' => 50]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        $capitalClanTop = Cache::remember("capitalClanTop_50_{$locationId}", 3600, function () use ($token, $base) {
            $res = Http::withToken($token)->get("{$base}/capitals", ['limit' => 50]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        return view('rankings.more_rankings', [
            'homeVillageTop' => $homeVillageTop,
            'builderBaseTop' => $builderBaseTop,
            'homeClanTop' => $homeClanTop,
            'builderClanTop' => $builderClanTop,
            'capitalClanTop' => $capitalClanTop,
            'isFullPage' => true, // used in the blade logic
            'limit' => 50,
            'locations' => $locations,
            'selectedLocationId' => $locationId
        ]);
    }


    public function search(Request $request)
    {
        $input = trim($request->input('tag'));

        if (str_starts_with($input, '#')) {
            $tag = urlencode($input);

            // Check if player exists
            $playerData = Cache::remember("player_search_{$tag}", 3600, function () use ($tag) {
                $res = Http::withToken(env('COC_API_TOKEN'))->get("https://api.clashofclans.com/v1/players/{$tag}");
                return $res->successful() ? $res->json() : null;
            });

            if ($playerData) {
                return redirect()->route('player.show', ['tag' => ltrim($input, '#')]);
            }

            // Check if clan exists
            $clanData = Cache::remember("clan_search_{$tag}", 3600, function () use ($tag) {
                $res = Http::withToken(env('COC_API_TOKEN'))->get("https://api.clashofclans.com/v1/clans/{$tag}");
                return $res->successful() ? $res->json() : null;
            });

            if ($clanData) {
                return redirect()->route('clan.show', ['tag' => ltrim($input, '#')]);
            }

            return view('player.index', ['error' => 'No player or clan found with this tag.']);
        }

        if (strlen($input) < 3) {
            return view('clan.clan_preview', ['error' => 'Search term must be at least 3 characters long.']);
        }

        $clans = Cache::remember("clan_name_search_{$input}", 3600, function () use ($input) {
            $res = Http::withToken(env('COC_API_TOKEN'))->get('https://api.clashofclans.com/v1/clans', [
                'name' => $input,
                'limit' => 100
            ]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        return view('clan.clan_preview', ['clans' => $clans]);
    }

    public function show($tag)
    {
        $tag = '#' . ltrim($tag, '#');

        $player = Cache::remember("player_info_{$tag}", 3600, function () use ($tag) {
            $res = Http::withToken(env('COC_API_TOKEN'))->get("https://api.clashofclans.com/v1/players/" . urlencode($tag));
            return $res->successful() ? $res->json() : null;
        });

        if (!$player) {
            return view('player.index', ['error' => 'Player not found.']);
        }

        // Make sure the player data is properly formatted
        if (is_array($player)) {
            return view('player.index', ['player' => $player]);
        }

        return view('player.index', ['error' => 'Invalid player data.']);
    }

    public function searchClans(Request $request)
    {
        $name = $request->query('name');
        if (!$name || strlen($name) < 3) {
            return view('clan.clan_preview', ['error' => 'Clan name must be at least 3 characters long.']);
        }

        $clans = Cache::remember("clan_search_name_{$name}", 3600, function () use ($name) {
            $res = Http::withToken(env('COC_API_TOKEN'))->get('https://api.clashofclans.com/v1/clans', [
                'name' => $name,
                'limit' => 100
            ]);
            return $res->successful() ? $res->json('items') ?? [] : [];
        });

        return view('clan.clan_preview', ['clans' => $clans]);
    }

    public function showClan($tag)
{
    $tag = '#' . ltrim($tag, '#');
    $token = env('COC_API_TOKEN');

    // Fetch clan data
    $clan = Cache::remember("clan_info_{$tag}", 3600, function () use ($tag, $token) {
        $res = Http::withToken($token)->get("https://api.clashofclans.com/v1/clans/" . urlencode($tag));
        if ($res->failed()) {
            \Log::error("Clan API request failed for {$tag}: {$res->status()}");
            return null;
        }
        return $res->successful() ? $res->json() : null;
    });

    if (!$clan) {
        return view('clan.clan', ['error' => 'Clan not found or invalid tag.']);
    }

    // Fetch current war
    $clan['currentWar'] = Cache::remember("clan_war_{$tag}", 600, function () use ($tag, $token) {
        $res = Http::withToken($token)->get("https://api.clashofclans.com/v1/clans/" . urlencode($tag) . "/currentwar");
        if ($res->failed()) {
            \Log::error("Current war API request failed for {$tag}: {$res->status()}");
            return null;
        }
        return $res->successful() ? $res->json() : null;
    });

    $clan['cwlGroup'] = Cache::remember("clan_cwl_{$tag}", 600, function () use ($tag, $token) {
        $res = Http::withToken($token)->get("https://api.clashofclans.com/v1/clans/" . urlencode($tag) . "/currentwar/leaguegroup");
        if ($res->failed()) {   
            \Log::error("CWL API failed for {$tag}: Status {$res->status()}, Body: {$res->body()}");
            return null;
        }
        $data = $res->successful() ? $res->json() : null;
        \Log::debug("CWL API response for {$tag}: ", [$data]);
        return $data;
    });

    // Initialize cwlWars array
    $clan['cwlWars'] = [];

    // Process CWL data if available
    if (isset($clan['cwlGroup']['rounds']) && is_array($clan['cwlGroup']['rounds'])) {
        // Process rounds data
        $rawRounds = $clan['cwlGroup']['rounds'];
        
        // Flatten in case rounds is [[...]] instead of [...]
        if (count($rawRounds) === 1 && is_array($rawRounds[0])) {
            $rawRounds = $rawRounds[0];
        }

        // Filter out empty rounds
        $filteredRounds = array_filter($rawRounds, function ($round) {
            if (!isset($round['warTags']) || !is_array($round['warTags'])) return false;
            
            foreach ($round['warTags'] as $tag) {
                if ($tag !== '#0') return true;
            }
            return false;
        });

        // Fetch war details for each valid war tag
        foreach ($filteredRounds as $round) {
            if (isset($round['warTags'])) {
                foreach ($round['warTags'] as $warTag) {
                    if ($warTag !== '#0') {
                        $clan['cwlWars'][$warTag] = Cache::remember("cwl_war_{$warTag}", 600, function () use ($warTag, $token) {
                            $res = Http::withToken($token)->get("https://api.clashofclans.com/v1/clanwarleagues/wars/" . urlencode($warTag));
                            if ($res->failed()) {
                                \Log::error("CWL war API request failed for {$warTag}: {$res->status()}");
                                return null;
                            }
                            return $res->successful() ? $res->json() : null;
                        });
                    }
                }
            }
        }

        // Structure the CWL data
        $clan['cwl'] = [
            'rounds' => array_values($filteredRounds), // reindex array after filtering
            'wars' => $clan['cwlWars']
        ];
    } else {
        $clan['cwl'] = [
            'rounds' => [],
            'wars' => []
        ];
    }

    \Log::debug("Final CWL data structure for {$tag}: ", [$clan['cwl']]);

    // Fetch war log
    $clan['warLog'] = Cache::remember("clan_warlog_{$tag}", 3600, function () use ($tag, $token) {
        $res = Http::withToken($token)->get("https://api.clashofclans.com/v1/clans/" . urlencode($tag) . "/warlog");
        if ($res->failed()) {
            \Log::error("War log API request failed for {$tag}: {$res->status()}");
            return null;
        }
        return $res->successful() ? $res->json() : null;
    });

    // Preprocess currentWar data
    if (isset($clan['currentWar']) && is_array($clan['currentWar']) && !empty($clan['currentWar']) && isset($clan['currentWar']['state']) && $clan['currentWar']['state'] !== 'notInWar') {
        $war = $clan['currentWar'];

        // Initialize defaults
        $war = array_merge([
            'state' => 'notInWar',
            'teamSize' => 0,
            'attacksPerMember' => 0,
            'clan' => [
                'members' => [],
                'stars' => 0,
                'destructionPercentage' => 0,
                'badgeUrls' => ['small' => asset('images/default_badge.png')],
                'name' => 'Unknown'
            ],
            'opponent' => [
                'members' => [],
                'stars' => 0,
                'destructionPercentage' => 0,
                'badgeUrls' => ['small' => asset('images/default_badge.png')],
                'name' => 'Unknown'
            ],
            'preparationStartTime' => null,
            'startTime' => null,
            'endTime' => null
        ], $war);

        // Parse timestamps
        $war['prepStart'] = isset($war['preparationStartTime'])
            ? \Carbon\Carbon::createFromFormat('Ymd\THis.v\Z', $war['preparationStartTime'])
            : null;
        $war['startTime'] = isset($war['startTime'])
            ? \Carbon\Carbon::createFromFormat('Ymd\THis.v\Z', $war['startTime'])
            : null;
        $war['endTime'] = isset($war['endTime'])
            ? \Carbon\Carbon::createFromFormat('Ymd\THis.v\Z', $war['endTime'])
            : null;

        // Sort clan members by map position
        if (isset($war['clan']['members']) && is_array($war['clan']['members']) && !empty($war['clan']['members'])) {
            usort($war['clan']['members'], function ($a, $b) {
                return ($a['mapPosition'] ?? 0) <=> ($b['mapPosition'] ?? 0);
            });
        } else {
            $war['clan']['members'] = [];
        }

        // Sort opponent members by map position
        if (isset($war['opponent']['members']) && is_array($war['opponent']['members']) && !empty($war['opponent']['members'])) {
            usort($war['opponent']['members'], function ($a, $b) {
                return ($a['mapPosition'] ?? 0) <=> ($b['mapPosition'] ?? 0);
            });
        } else {
            $war['opponent']['members'] = [];
        }

        // Create defender names map
        $defenderNames = [];
        foreach ([$war['clan']['members'], $war['opponent']['members']] as $members) {
            if (is_array($members)) {
                foreach ($members as $member) {
                    if (isset($member['tag'], $member['name']) && is_string($member['tag']) && is_string($member['name'])) {
                        $defenderNames[$member['tag']] = $member['name'];
                    }
                }
            }
        }

        // Update war data
        $clan['currentWar'] = $war;
        $clan['defenderNames'] = $defenderNames;
    } else {
        \Log::debug("No valid war data for clan {$tag}", [$clan['currentWar'] ?? 'not set']);
        $clan['currentWar'] = [];
        $clan['defenderNames'] = [];
    }

    return view('clan.clan', ['clan' => $clan]);
}
}