<?php

namespace Tests\Feature\Requests;

use App\Models\MailConnection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailConnectionUpdateRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function メールアドレスのバリデーション_空の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'email' => '',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['email' => trans('mail_connection.errors.email.email')]);
    }

    /** @test */
    public function メールアドレスのバリデーション_文字列の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'email' => 'aaaaa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['email' => trans('mail_connection.errors.email.email')]);
    }

    /** @test */
    public function メールアドレスのバリデーション_数値の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $user           = User::factory()->create();
        $param          = [
            'email' => 100,
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['email' => trans('mail_connection.errors.email.email')]);
    }

    /** @test */
    public function メールアドレスのバリデーション_配列の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'email' => ['test@example.com'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['email' => trans('mail_connection.errors.email.email')]);
    }

    /** @test */
    public function メールアドレスのバリデーション_メールアドレスの場合はOK(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'email' => $user->email,
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertValid('email');
    }

    /** @test */
    public function パスワードのバリデーション_数値の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'password' => 100,
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['password' => trans('mail_connection.errors.password.string')]);
    }

    /** @test */
    public function パスワードのバリデーション_配列の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'password' => ['test@example.com'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['password' => trans('mail_connection.errors.password.string')]);
    }

    /** @test */
    public function パスワードのバリデーション_文字列の場合はOK(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'password' => 'aaaaa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertValid('password');
    }

    /** @test */
    public function パスワードのバリデーション_空の場合はOK(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = ['password' => ''];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertValid('password');
    }

    /** @test */
    public function メールボックスのバリデーション_数値の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => 100,
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['mail_box' => trans('mail_connection.errors.mail_box.string')]);
    }

    /** @test */
    public function メールボックスのバリデーション_配列の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => ['test@example.com'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['mail_box' => trans('mail_connection.errors.mail_box.string')]);
    }

    /** @test */
    public function メールボックスのバリデーション_マルチバイト文字列の混合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => 'ああああaaa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['mail_box' => trans('mail_connection.errors.mail_box.regex')]);
    }

    /** @test */
    public function メールボックスのバリデーション_記号の混合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => 'a-aa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['mail_box' => trans('mail_connection.errors.mail_box.regex')]);
    }

    /** @test */
    public function メールボックスのバリデーション_数値の混合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => 'a22aa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['mail_box' => trans('mail_connection.errors.mail_box.regex')]);
    }

    /** @test */
    public function メールボックスのバリデーション_英字のみはOK(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => 'aaaaa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertValid('mail_box');
    }

    /** @test */
    public function メールボックスのバリデーション_空はOK(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'mail_box' => '',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertValid('mail_box');
    }

    /** @test */
    public function 件名のバリデーション_空の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'subject' => '',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['subject' => trans('mail_connection.errors.subject.string')]);
    }

    /** @test */
    public function 件名のバリデーション_数値の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'subject' => 100,
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['subject' => trans('mail_connection.errors.subject.string')]);
    }

    /** @test */
    public function 件名のバリデーション_配列の場合はNG(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'subject' => ['test@example.com'],
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertRedirect(route('mail_connection.edit', $mailConnection))
            ->assertInvalid(['subject' => trans('mail_connection.errors.subject.string')]);
    }

    /** @test */
    public function 件名のバリデーション_文字列の場合はOK(): void
    {
        $user           = User::factory()->create();
        $mailConnection = MailConnection::factory()->create(['user_id' => $user->id]);
        $param          = [
            'subject' => 'aaaaa',
        ];

        $this->actingAs($user);
        $url = route('mail_connection.update', $mailConnection);
        $this->from(route('mail_connection.edit', $mailConnection));
        $this->put($url, $param)
            ->assertValid('subject');
    }
}
