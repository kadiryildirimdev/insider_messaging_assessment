<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateBulkMessageRequestTest extends TestCase
{
    public function test_create_bulk_request_validation_success()
    {
        $payload = [
            'user_type_code' => '00001',
            'content' => 'test',
        ];

        $response = $this->postJson('/api/messages/createBulk', $payload);

        $response->assertStatus(200);
    }

    public function test_create_bulk_request_validation_fail_missing_content()
    {
        $payload = [
            'user_type_code' => '00001',
            //'content' => 'test',
        ];

        $response = $this->postJson('/api/messages/createBulk', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['content']);
    }

    public function test_create_bulk_request_validation_fail_missing_user_type_code()
    {
        $payload = [
            //'user_type_code' => '00001',
            'content' => 'test',
        ];

        $response = $this->postJson('/api/messages/createBulk', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_type_code']);
    }

    public function test_create_bulk_request_validation_fail_invalid_user_type_code()
    {
        $payload = [
            'user_type_code' => '99999',
            'content' => 'test',
        ];

        $response = $this->postJson('/api/messages/createBulk', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['user_type_code']);
    }

    public function test_create_message_stores_in_db()
    {
        $payload = [
            'user_type_code' => '00001',
            'content' => 'test bulk message',
        ];

        $response = $this->postJson('/api/messages/createBulk', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('messages', [
            'content' => 'test bulk message',
        ]);
    }
}
