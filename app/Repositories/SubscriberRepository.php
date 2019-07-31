<?php
namespace App\Repositories;
use App\Subscriber;

class SubscriberRepository
{
    public function all()
    {
        return Subscriber::all();
    }

    public function add($data)
    {
        $s = new Subscriber;
        $s->email = $data['email'];
        $s->group = $data['group'];

        if ($s->save()) {
            return $s;
        }

        return null;
    }

    public function paginate($take = 15)
    {
        return Subscriber::orderBy('id', 'desc')->paginate($take);
    }

    public function getByEmailAndGroup($email, $group)
    {
        return Subscriber::where('group', $group)->where('email', $email)->first();
    }

    public function delete($sub)
    {
        return $sub->delete();
    }
}
