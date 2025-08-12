<?php


use Tests\TestCase;

class CreateMessageRequestTest extends TestCase
{
    public function test_create_message_validation_success()
    {
        $payload = [
            'content' => 'test',
            'phone_number' => '00905538876292',
        ];

        $response = $this->postJson('/api/messages/create', $payload);

        $response->assertStatus(200);
    }

    public function test_create_message_validation_fail_missing_phone_number()
    {
        $payload = [
            'content' => 'test',
            //'phone_number' => '00905538876292',
        ];

        $response = $this->postJson('/api/messages/create', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone_number']);
    }

    public function test_create_message_validation_fail_invalid_phone_number_length()
    {
        $payload = [
            'content' => 'test',
            'phone_number' => '123',
        ];

        $response = $this->postJson('/api/messages/create', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['phone_number']);
    }

    public function test_create_message_stores_in_db()
    {
        $payload = [
            'content' => 'test message',
            'phone_number' => '00905538876292',
        ];

        $response = $this->postJson('/api/messages/create', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'content' => 'test message',
        ]);
    }
}
