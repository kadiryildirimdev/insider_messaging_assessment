<?php

namespace App\Jobs;

use App\Enums\MessageStatusEnum;
use App\Interfaces\MessageRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Random\RandomException;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $messageId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     */
    public function handle(MessageRepositoryInterface $messageRepository): void
    {
        $message = $messageRepository->read($this->messageId);

        if ($message === null) {
            return;
        }

        $flag = false;
        $counter = $message->messageReceivers()->whereNull('sent_at')->count();

        if ($counter > 0) {
            $flag = true;
        }

        $pendingReceivers = $message->messageReceivers()->whereNull('sent_at')->limit(2)->get();

        foreach ($pendingReceivers as $receiver) {
            if ($receiver->sent_at === null) {
                $result = $this->sendMessage();

                if ($result !== null) {
                    $receiver->transaction_id = $result;
                    $receiver->sent_at = \Carbon\Carbon::now();
                    $receiver->save();
                    Log::info("GÖNDERME BAŞARILI ---> Mesaj #{$message->id} {$receiver->phone_number} numarasına mesaj gönderildi.");
                }else{
                    Log::warning("GÖNDERME BAŞARISIZ ---> Mesaj #{$message->id} {$receiver->phone_number} numarasına mesaj gönderilemedi.");
                }
            }
        }

        $messageStatus = $messageRepository->findMessageStatusByCode(MessageStatusEnum::SENT->value);

        $message->ref_message_status = $messageStatus?->id;
        $message->save();

        if ($flag) {
            sleep(5);
            Log::info("Kuyrukta bekleyen {$counter} adet gönderim mevcut. Kuyruk tekrar çalıştırılıyor.");

            self::dispatch($message->id);
        }
    }

    /**
     * Parameters will be determined
     * @return string|null
     * @throws RandomException
     */
    public function sendMessage(): ?string
    {

        // TODO: sending message will be implemented in this function
        $result = (bool) random_int(0, 1);
        if($result){
            return Str::uuid();
        }

        return null;
    }
}
