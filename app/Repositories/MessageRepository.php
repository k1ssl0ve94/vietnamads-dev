<?php

namespace App\Repositories;


use App\Message;
use App\User;
use Illuminate\Support\Facades\DB;

class MessageRepository
{
    public function sendMessage($fromId, $toId, $content, $fromProduct = null)
    {
        $message = new Message();
        $message->fill([
            'from_user' => $fromId,
            'to_user' => $toId,
            'content' => $content,
            'status' => Message::STATUS_NEW,
            'product_id' => $fromProduct,
        ]);
        return $message->save();
    }

    public function countUnreadByUser($userId)
    {
        $nb =  Message::query()->where('to_user', $userId)
            ->where('status', Message::STATUS_NEW)
            ->count();
        return $nb;
    }

    public function getSenderList($toUser, $page = 1)
    {
        $items = Message::query()
            ->where(function ($builder) use ($toUser){
                $builder->where('to_user', $toUser)
                    ->orWhere('from_user', $toUser);
            })->get();
        $userIds = [];
        if ($items) {
            foreach ($items as $item) {
                $userIds[$item->to_user] = $item->to_user;
                $userIds[$item->from_user] = $item->from_user;
            }
        }
        if (isset($userIds[$toUser])) {
            unset($userIds[$toUser]);
        }
        $items = null;
        if (count($userIds)) {
            $items = User::query()->whereIn('id', $userIds)
                ->paginate(10, [
                    'users.*'
                ], 'page', $page);
        }
        return $items;
    }

    public function getContentOfThread($fromUser, $toUser)
    {
        $items = Message::query()
            ->whereIn('from_user', [$fromUser, $toUser])
            ->whereIn('to_user', [$fromUser, $toUser])
            ->orderBy('id')
            ->get();
        return $items;
    }

    public function markReadFor($fromUser, $toUser)
    {
        Message::query()
            ->where('from_user', $fromUser)
            ->where('to_user', $toUser)
            ->where('status', Message::STATUS_NEW)
            ->update([
                'status' => Message::STATUS_READ,
            ]);
        $unreadNumber = $this->countUnreadByUser($toUser);
        User::query()->where('id', $toUser)
            ->update([
                'unread_message' => $unreadNumber,
            ]);
    }
}