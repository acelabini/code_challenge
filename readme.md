## Introduction
Code challenge

### Installation

- Clone this repository
- Copy .env.example to .env 
    - `cp .env.example .env`
- Generate a key
    - `php artisan key:generate`
- Run the migration 
    - `php artisan migrate`
- Run the scheduler to sync players
    - `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
    - the cron job runs every minute
- To change the configuration open `.env` , edit the following variables
```env
PREMIER_LEAGUE_URL=https://fantasy.premierleague.com/api/
PREMIER_LEAGUE_FORMAT=json
PREMIER_LEAGUE_MIN_DATA=100
PREMIER_LEAGUE_INDEX=elements
```


### Endpoints

- Get all players
    - Paginated player lists
```http
GET /api/players
```

#### Response
```json
{ 
   "data":{ 
      "current_page":1,
      "data":[ 
         { 
            "id":1,
            "full_name":"Shkodran Mustafi"
         },
         { 
            "id":2,
            "full_name":"Héctor Bellerín"
         },
         { 
            "id":3,
            "full_name":"Sead Kolasinac"
         },
         { 
            "id":4,
            "full_name":"Ainsley Maitland-Niles"
         },
         { 
            "id":5,
            "full_name":"Sokratis Papastathopoulos"
         },
         { 
            "id":6,
            "full_name":"Nacho Monreal"
         },
         { 
            "id":7,
            "full_name":"Laurent Koscielny"
         },
         { 
            "id":8,
            "full_name":"Konstantinos Mavropanos"
         },
         { 
            "id":9,
            "full_name":"Carl Jenkinson"
         },
         { 
            "id":10,
            "full_name":"Rob Holding"
         },
         { 
            "id":11,
            "full_name":"Pierre-Emerick Aubameyang"
         },
         { 
            "id":12,
            "full_name":"Alexandre Lacazette"
         },
         { 
            "id":13,
            "full_name":"Edward Nketiah"
         },
         { 
            "id":14,
            "full_name":"Bernd Leno"
         },
         { 
            "id":15,
            "full_name":"Mesut Özil"
         }
      ],
      "first_page_url":"http:\/\/api.challenge.test\/api\/players?page=1",
      "from":1,
      "last_page":38,
      "last_page_url":"http:\/\/api.challenge.test\/api\/players?page=38",
      "next_page_url":"http:\/\/api.challenge.test\/api\/players?page=2",
      "path":"http:\/\/api.challenge.test\/api\/players",
      "per_page":15,
      "prev_page_url":null,
      "to":15,
      "total":560
   }
}
```

- Get player by id
```http
GET /api/players/{id}
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `id` | `int` | **Required**. Player id |

#### Response
```json
{ 
   "data":{ 
      "id":213,
      "bps":16,
      "code":33148,
      "form":"0.3",
      "news":"",
      "team":11,
      "bonus":0,
      "photo":"33148.jpg",
      "saves":2,
      "status":"a",
      "threat":"0.0",
      "assists":0,
      "ep_next":"1.3",
      "ep_this":"0.8",
      "minutes":90,
      "special":false,
      "now_cost":48,
      "web_name":"Bravo",
      "ict_index":"1.6",
      "influence":"16.2",
      "own_goals":0,
      "red_cards":0,
      "team_code":43,
      "creativity":"0.0",
      "first_name":"Claudio",
      "news_added":"2019-06-25T11:30:07.160148Z",
      "value_form":"0.1",
      "second_name":"Bravo",
      "clean_sheets":0,
      "element_type":1,
      "event_points":0,
      "goals_scored":0,
      "in_dreamteam":false,
      "squad_number":null,
      "total_points":1,
      "transfers_in":9272,
      "value_season":"0.2",
      "yellow_cards":0,
      "transfers_out":18706,
      "goals_conceded":3,
      "dreamteam_count":0,
      "penalties_saved":0,
      "points_per_game":"1.0",
      "penalties_missed":0,
      "cost_change_event":0,
      "cost_change_start":-2,
      "transfers_in_event":103,
      "selected_by_percent":"0.3",
      "transfers_out_event":1561,
      "cost_change_event_fall":0,
      "cost_change_start_fall":2,
      "chance_of_playing_next_round":100,
      "chance_of_playing_this_round":100
   }
}
```
