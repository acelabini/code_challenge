<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Player::class, function (Faker $faker) {
    $id = 99999;
    return [
        'id'        =>  $id,
        'player_id' =>  $id,
        'player_information' => [
            'id' => $id,
            'bps' => 133,
            'code' => 111457,
            'form' => '0.8',
            'news' => 'Hamstring injury - 75% chance of playing',
            'team' => 1,
            'bonus' => 1,
            'photo' => '111457.jpg',
            'saves' => 0,
            'status' => 'd',
            'threat' => '45.0',
            'assists' => 1,
            'ep_next' => '1.4',
            'ep_this' => '1.4',
            'minutes' => 667,
            'special' => false,
            'now_cost' => 53,
            'web_name' => 'Kolasinac',
            'ict_index' => '27.8',
            'influence' => '122.8',
            'own_goals' => 0,
            'red_cards' => 0,
            'team_code' => 3,
            'creativity' => '111.5',
            'first_name' => 'Sead',
            'news_added' => '2019-11-21T14:30:19.207005Z',
            'value_form' => '0.2',
            'second_name' => 'Kolasinac',
            'clean_sheets' => 1,
            'element_type' => 2,
            'event_points' => 0,
            'goals_scored' => 0,
            'in_dreamteam' => false,
            'squad_number' => null,
            'total_points' => 19,
            'transfers_in' => 43522,
            'value_season' => '3.6',
            'yellow_cards' => 2,
            'transfers_out' => 99938,
            'goals_conceded' => 10,
            'dreamteam_count' => 0,
            'penalties_saved' => 0,
            'points_per_game' => '1.9',
            'penalties_missed' => 0,
            'cost_change_event' => 0,
            'cost_change_start' => -2,
            'transfers_in_event' => 8,
            'selected_by_percent' => '0.7',
            'transfers_out_event' => 1757,
            'cost_change_event_fall' => 0,
            'cost_change_start_fall' => 2,
            'chance_of_playing_next_round' => 75,
            'chance_of_playing_this_round' => 75,
        ]
    ];
});
