<?php

namespace Tests\Feature;

use App\Models\MailConnection;
use App\Models\User;
use App\Services\EncryptService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailConnectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 一覧表示のテスト(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        MailConnection::factory()->create([
            'user_id' => $user1->id,
            'email'   => 'test1@example.com',
        ]);
        MailConnection::factory()->create([
            'user_id' => $user2->id,
            'email'   => 'test2@example.com',
        ]);
        MailConnection::factory()->create([
            'user_id' => $user1->id,
            'email'   => 'test3@example.com',
        ]);

        $this->actingAs($user1);
        $url = route('mail_connection.index');
        $this->get($url)
            ->assertOk()
            ->assertSee('test1@example.com')
            ->assertDontSee('test2@example.com')
            ->assertSee('test3@example.com');
    }

    /** @test */
    public function 一覧表示のテスト_ログインなし(): void
    {
        $url = route('mail_connection.index');
        $this->get($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 登録画面のテスト(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $url = route('mail_connection.create');
        $this->get($url)
            ->assertOk()
            ->assertSee('明細メール受信アドレス登録');
    }

    /** @test */
    public function 登録画面のテスト_ログインなし(): void
    {
        $url = route('mail_connection.create');
        $this->get($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 登録のテスト_メールボックスあり(): void
    {
        $user = User::factory()->create();
        $param = [
            'email'    => 'test3@example.com',
            'password' => 'password',
            'mail_box' => 'mailbox',
            'subject'  => 'テスト1',
        ];
        $expect = [
            'user_id'         => $user->id,
            'email'           => $param['email'],
            'mail_box'        => $param['mail_box'],
            'host'            => config('const.mail_connection.host'),
            'port'            => config('const.mail_connection.port'),
            'subject'         => $param['subject'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.store');
        $this->post($url, $param)
            ->assertRedirect(route('mail_connection.index'));
        
        $this->assertDatabaseHas('mail_connections', $expect);

        $this->get(route('mail_connection.index'))
            ->assertSee('明細メール受信アドレスの登録が完了しました。');
    }

    /** @test */
    public function 登録のテスト_メールボックスなし(): void
    {
        $user = User::factory()->create();
        $param = [
            'email'    => 'test4@example.com',
            'password' => 'password',
            'subject'  => 'テスト2',
        ];
        $expect = [
            'user_id'         => $user->id,
            'email'           => $param['email'],
            'mail_box'        => config('const.mail_connection.default_mail_box'),
            'host'            => config('const.mail_connection.host'),
            'port'            => config('const.mail_connection.port'),
            'subject'         => $param['subject'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.store');
        $this->post($url, $param)
            ->assertRedirect(route('mail_connection.index'));
        
        $this->assertDatabaseHas('mail_connections', $expect);

        $this->get(route('mail_connection.index'))
            ->assertSee('明細メール受信アドレスの登録が完了しました。');
    }

    /** @test */
    public function 登録のテスト_ログインなし(): void
    {
        $user = User::factory()->create();
        $param = [
            'email'    => 'test5@example.com',
            'password' => 'password',
            'subject'  => 'テスト3',
        ];

        $url = route('mail_connection.store');
        $this->post($url, $param)
            ->assertRedirect(route('login'));
        
    }

    /** @test */
    public function 編集画面のテスト(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create([
            'user_id' => $user->id,
            'email'   => 'test6@example.com',
        ]);

        $this->actingAs($user);
        $url = route('mail_connection.edit', $mailConnection);
        $this->get($url)
            ->assertOk()
            ->assertSee('明細メール受信アドレス編集');
    }

    /** @test */
    public function 編集画面のテスト_ログインなし(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create([
            'user_id' => $user->id,
            'email'   => 'test6@example.com',
        ]);

        $url = route('mail_connection.edit', $mailConnection);
        $this->get($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 編集のテスト(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create([
            'user_id' => $user->id,
            'host'    => config('const.mail_connection.host'),
            'port'    => config('const.mail_connection.port'),
        ]);
        $param = [
            'email'    => 'test7@example.com',
            'mail_box' => 'mailbox',
            'subject'  => 'テスト1_編集',
        ];
        $expect = [
            'user_id'         => $user->id,
            'email'           => $param['email'],
            'mail_box'        => $param['mail_box'],
            'host'            => config('const.mail_connection.host'),
            'port'            => config('const.mail_connection.port'),
            'subject'         => $param['subject'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.index'));
        
        $this->assertDatabaseHas('mail_connections', $expect);

        $this->get(route('mail_connection.index'))
            ->assertSee('明細メール受信アドレスの更新が完了しました。');
    }

    /** @test */
    public function 編集のテスト_ログインなし(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create([
            'user_id' => $user->id,
            'host'    => config('const.mail_connection.host'),
            'port'    => config('const.mail_connection.port'),
        ]);
        $param = [
            'email'    => 'test7@example.com',
            'mail_box' => 'mailbox',
            'subject'  => 'テスト1_編集',
        ];

        $url = route('mail_connection.update', $mailConnection);
        $this->put($url, $param)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 削除のテスト():void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create([
            'user_id' => $user->id,
            'host'    => config('const.mail_connection.host'),
            'port'    => config('const.mail_connection.port'),
        ]);
        $expect         = [
            'user_id'         => $mailConnection->id,
            'email'           => $mailConnection->email,
            'cipher_password' => $mailConnection->cipher_password,
            'mail_box'        => $mailConnection->mail_box,
            'host'            => $mailConnection->host,
            'port'            => $mailConnection->port,
            'subject'         => $mailConnection->subject,
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->delete($url)
            ->assertRedirect(route('mail_connection.index'));

        $this->assertDatabaseMissing('mail_connections', $expect);

        $this->get(route('mail_connection.index'))
            ->assertSee('明細メール受信アドレスの削除が完了しました。');
    }

    /** @test */
    public function 削除のテスト_ログインなし():void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create([
            'user_id' => $user->id,
            'host'    => config('const.mail_connection.host'),
            'port'    => config('const.mail_connection.port'),
        ]);

        $url = route('mail_connection.update', $mailConnection);
        $this->delete($url)
            ->assertRedirect(route('login'));
    }
}
