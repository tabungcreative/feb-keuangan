<?php

namespace Tests\Feature\Services;

use App\Services\MahasiswaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MahasiswaServiceTest extends TestCase
{
    private MahasiswaService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(MahasiswaService::class);
    }

    public function test_check_nim_found()
    {
        $nim = 'd83c00b8-52b8-3cf7-a781-3fad832f7f39';
        $result = $this->service->checkNim($nim);
        $this->assertTrue($result);
    }

    public function test_check_nim_not_found()
    {
        $nim = 'salah';
        $result = $this->service->checkNim($nim);
        $this->assertFalse($result);
    }
}
