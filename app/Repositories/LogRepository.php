<?php

namespace App\Repositories;

use App\AdminLog;

class LogRepository
{
    public function add($data)
    {
        $log = new AdminLog;

        if (isset($data['admin_id'])) {
            $log->admin_id = $data['admin_id'];
        }

        if (isset($data['user_id'])) {
            $log->user_id = $data['user_id'];
        }

        if (isset($data['action'])) {
            $log->action = $data['action'];
        }

        if (isset($data['message'])) {
            $log->message = $data['message'];
        }

        if (isset($data['metadata'])) {
            $log->metadata = json_encode($data['metadata']);
        }

        if ($log->save()) {
            return $log;
        }

        return null;
    }

    public function paginate($take = 20)
    {
        return AdminLog::with(['admin', 'user'])->orderBy('id', 'desc')->paginate($take);
    }
}