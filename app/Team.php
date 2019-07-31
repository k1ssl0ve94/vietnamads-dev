<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $casts = [
        'channels' => 'array',
        'roles'    => 'array',
        'products' => 'array',
    ];

    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id', 'id');
    }

    public function members()
    {
        return $this->belongsToMany('App\User', 'team_user', 'team_id', 'user_id')
                    ->withPivot('role', 'products');;
    }

    public function publicData($force = false)
    {
        $team = $this->toArray();

        if ($force) {
            $team['leader'] = $this->leader()->get()->toArray();
            $team['members'] = $this->members()->get()->toArray();
        } else {
            $team['leader'] = $this->leader->toArray();
            $team['members'] = $this->members->toArray();
        }


        return $team;
    }
}
