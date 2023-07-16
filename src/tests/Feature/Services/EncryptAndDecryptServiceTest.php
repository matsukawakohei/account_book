<?php

namespace Tests\Feature\Services;

use App\Services\DecryptService;
use App\Services\EncryptService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EncryptAndDecryptServiceTest extends TestCase
{
    /** @test */
    public function 暗号化と復号化のテスト(): void
    {
        $rowText = 'test_string';

        $cipherText = EncryptService::execEncrypt($rowText);
        $resultText = DecryptService::execDecrypt($cipherText);

        $this->assertSame($rowText, $resultText);
    }
}
