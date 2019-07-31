<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Repositories\SubscriberRepository;

class SubscriberController extends Controller
{
    protected $subRepo;

    public function __construct(SubscriberRepository $subRepo)
    {
        $this->subRepo = $subRepo;
    }

    public function create()
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        $sub = $this->subRepo->getByEmailAndGroup(request()->email, 'default');

        if ($sub) {
            return ['status' => 1];
        }

        $data = [
            'email' => request()->email,
            'group' => 'default',
        ];

        if ($sub = $this->subRepo->add($data)) {
            return ['status' => 1];
        }

        return ['status' => 0];
    }
}
