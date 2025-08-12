<?php

namespace App\Console\Commands;

use App\Interfaces\MessageRepositoryInterface;
use App\Jobs\SendMessageJob;
use Illuminate\Console\Command;

class SendPendingMessages extends Command
{
    protected $signature = 'messages:send-pending';

    protected $description = 'Gönderilmemiş mesajları kuyrukta işlemek için komut';

    protected MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        parent::__construct();
        $this->messageRepository = $messageRepository;
    }

    public function handle()
    {
        $pendingMessages = $this->messageRepository->getPendingMessages();

        foreach ($pendingMessages as $message) {
            if ($message->messageReceivers->isEmpty()) {
                $this->info('Gönderilecek mesaj yok.');
                return 0;
            }
            SendMessageJob::dispatch($message->id);
            $this->info("Mesaj #{$message->id} gönderim için kuyruğa alındı.");
        }

        $this->info('Tüm gönderilmemiş mesajlar işlendi.');

        return 0;
    }
}
