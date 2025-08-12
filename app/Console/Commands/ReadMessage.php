<?php

namespace App\Console\Commands;

use App\DTOs\MessageDTO;
use App\Interfaces\MessageRepositoryInterface;
use App\Requests\ReadMessageRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Command\Command as CommandAlias;

/**
 *
 */
class ReadMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:read {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ID ile mesaj görüntüleme';

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
            'id' => $this->argument('id')
        ];

        $validator = Validator::make($data, (new ReadMessageRequest())->rules());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->info($error);
            }
            return CommandAlias::FAILURE;
        }

        $message = $this->messageRepository->read($data['id']);

        $result = new MessageDTO($message?->toArray());
        print_r($result);

        return $result;
    }
}
