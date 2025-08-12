<?php

namespace App\Console\Commands;

use App\Interfaces\MessageRepositoryInterface;
use App\Jobs\SendMessageJob;
use App\Requests\CreateMessageRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 *
 */
class SendSingleMessage extends Command
{
    /**
     * @var string
     */
    protected $signature = 'message:send {phone_number} {content}';

    /**
     * @var string
     */
    protected $description = 'Komut ile tekli mesaj gönderme işlemi';

    /**
     * @var MessageRepositoryInterface
     */
    protected MessageRepositoryInterface $messageRepository;

    /**
     * @param MessageRepositoryInterface $messageRepository
     */
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
                $this->info($error);
            }
            return CommandAlias::FAILURE;
        }

        $message = $this->messageRepository->create($data);

        if ($message === null) {
            return CommandAlias::FAILURE;
        }

        print_r("\r\nMesaj ve alıcı oluşturuldu, gönderim kuyruğa eklendi.\r\n");

        SendMessageJob::dispatch($message->id);

        return CommandAlias::SUCCESS;
    }
}
