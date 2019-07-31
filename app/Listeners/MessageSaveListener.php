<?php

namespace App\Listeners;


use App\Events\MessageEvent;
use App\Message;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;

class MessageSaveListener
{
    protected $messageRepository;
    protected $userRepository;

    public function __construct(MessageRepository $messageRepository,
        UserRepository $userRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(MessageEvent $event)
    {
        $message = $event->message;
        /** @var $message Message */
        if ($message->to_user) {
            $user = $this->userRepository->getById($message->to_user);
            if ($user) {
                $this->userRepository->update($user, [
                   'unread_message' => $this->messageRepository->countUnreadByUser($message->to_user),
                ]);
            }
        }
    }
}