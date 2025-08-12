<?php

namespace App\Console\Commands;

use App\Interfaces\MessageRepositoryInterface;
use App\Jobs\SendMessageJob;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SendPendingMessages extends Command
{
    protected $signature = 'message:send-pending';

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

        if ($pendingMessages === null || $pendingMessages->isEmpty()) {
            print_r("\r\nGönderilecek mesaj yok.\r\n");
            return CommandAlias::SUCCESS;
        }

        foreach ($pendingMessages as $message) {
            if ($message->messageReceivers->isEmpty()) {
                print_r("\r\nGönderilecek mesaj yok.\r\n");
                return CommandAlias::SUCCESS;
            }
            print_r("\r\nMesaj #{$message->id} gönderim için kuyruğa alındı.\r\n");
            SendMessageJob::dispatch($message->id);
        }

        print_r("\r\nTüm gönderilmemiş mesajlar işlendi.\r\n");

        return CommandAlias::SUCCESS;
    }
}
