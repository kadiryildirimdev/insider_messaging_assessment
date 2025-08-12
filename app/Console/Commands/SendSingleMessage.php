<?php

namespace App\Console\Commands;

use App\Interfaces\MessageRepositoryInterface;
use App\Jobs\SendMessageJob;
use App\Requests\CreateMessageRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class SendSingleMessage extends Command
{
    protected $signature = 'message:send {phone_number} {content}';

    protected $description = 'Tek mesaj gönderimi: DB kaydı ve queue dispatch';

    protected MessageRepositoryInterface $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        parent::__construct();

        $this->messageRepository = $messageRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
            'content' => $this->argument('content'),
            'phone_number' => $this->argument('phone_number'),
        ];

        $validator = Validator::make($data, (new CreateMessageRequest())->rules());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $message = $this->messageRepository->create($data);

        if ($message === null) {
            return 1;
        }

        SendMessageJob::dispatch($message->id);

        $this->info("Mesaj ve alıcı oluşturuldu, gönderim kuyruğa eklendi.");

        return 0;
    }
}
