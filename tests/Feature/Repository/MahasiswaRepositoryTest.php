<?php

namespace Tests\Feature\Repository;

use App\Repositories\MahasiswaRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class MahasiswaRepositoryTest extends TestCase
{

    private MahasiswaRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(MahasiswaRepository::class);
    }
    public function test_get_all()
    {
        $result = $this->repository->getAll();
        assertNotNull($result);
    }

    public function test_find_by_nim()
    {
        $nim = 'd83c00b8-52b8-3cf7-a781-3fad832f7f39';
        $result = $this->repository->findByNim($nim);
        assertNotNull($result);
        $this->assertSame($nim, $result['nim']);
    }
}
