<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase; // 1. Tambahkan ini di atas
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HalamanPublikTest extends TestCase
{
    use RefreshDatabase; // 2. Tambahkan baris ini di dalam class

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}