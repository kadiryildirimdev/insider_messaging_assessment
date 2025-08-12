<?php

namespace App\Jobs;

use App\Enums\MessageStatusEnum;
use App\Interfaces\MessageRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
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
            $result = $this->sendMessage();

            if ($result !== null) {
                $now = \Carbon\Carbon::now();
                $receiver->transaction_id = $result;
                $receiver->sent_at = $now;
                $receiver->save();
                print_r("\r\nGÖNDERME BAŞARILI ---> Mesaj #" . $message->id . " " . $receiver->phone_number . " numarasına mesaj gönderildi.\r\n");
                $counter--;

                $data = [
                    'message_id' => $message->id,
                    'message_receiver_id' => $receiver->id,
                    'phone_number' => $receiver->phone_number,
                    'sent_at' => now()->toDateTimeString()
                ];

                $key = "messages_{$message->id}";

                Redis::rpush($key, json_encode($data));

                Redis::expire($key, 600);
            } else {
                print_r("\r\nGÖNDERME BAŞARISIZ ---> Mesaj #{$message->id} {$receiver->phone_number} numarasına mesaj gönderilemedi.\r\n");
            }
        }

        if ($counter === 0) {
            $messageStatus = $messageRepository->findMessageStatusByCode(MessageStatusEnum::SENT->value);
        } else {
            $messageStatus = $messageRepository->findMessageStatusByCode(MessageStatusEnum::PARTIAL_SENT->value);
        }

        $message->ref_message_status = $messageStatus?->id;
        $message->save();

        if ($flag) {
            sleep(5);
            print_r("\r\nKuyrukta bekleyen {$counter} adet gönderim mevcut. Kuyruk tekrar çalıştırılıyor.\r\n");

            self::dispatch($message->id);
        }

        print_r("\r\nKuyrukta bekleyen gönderimler tamamlandı.\r\n");
    }

    /**
     * Parameters will be determined
     * @return string|null
     * @throws RandomException
     */
    public function sendMessage(): ?string
    {
        // TODO: sending message will be implemented in this function
        $result = (bool)random_int(0, 1);
        if ($result) {
            return Str::uuid();
        }

        return null;
    }
}
