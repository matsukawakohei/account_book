<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManualAccountRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 明細名のバリデーション_空の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => '',
            'amount' => 1000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['name' => trans('account.errors.name.string')]);
    }

    /** @test */
    public function 明細名のバリデーション_配列の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => ['a', 'b'],
            'amount' => 1000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['name' => trans('account.errors.name.string')]);
    }

    /** @test */
    public function 明細名のバリデーション_50文字より多い場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 51),
            'amount' => 1000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['name' => trans('account.errors.name.max')]);
    }

    /** @test */
    public function 明細名のバリデーション_数字の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => 1,
            'amount' => 1000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['name' => trans('account.errors.name.string')]);
    }

    /** @test */
    public function 明細名のバリデーション_50文字の場合はOK(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 50),
            'amount' => 1000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertValid('name');
    }

    /** @test */
    public function 明細名のバリデーション_1文字の場合はOK(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 1000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertValid('name');
    }

    /** @test */
    public function 金額のバリデーション_空の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => '',
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['amount' => trans('account.errors.amount.integer')]);
    }

    /** @test */
    public function 金額のバリデーション_文字列の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 'aaaa',
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['amount' => trans('account.errors.amount.integer')]);
    }

    /** @test */
    public function 金額のバリデーション_配列の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => [1],
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['amount' => trans('account.errors.amount.integer')]);
    }

    /** @test */
    public function 金額のバリデーション_少数の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 1.1,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['amount' => trans('account.errors.amount.integer')]);
    }

    /** @test */
    public function 金額のバリデーション_0の場合はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 0,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['amount' => trans('account.errors.amount.min')]);
    }

    /** @test */
    public function 金額のバリデーション_1の場合はOK(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 1,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertValid('amount');
    }

    /** @test */
    public function 金額のバリデーション_1より大きい場合はOK(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertValid('amount');
    }

    /** @test */
    public function 支払日のバリデーション_空はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100,
            'account_date' => ''
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['account_date' => trans('account.errors.date.date')]);
    }

    /** @test */
    public function 支払日のバリデーション_日付ではない文字列はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100,
            'account_date' => 'aaaaa'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['account_date' => trans('account.errors.date.date')]);
    }

    /** @test */
    public function 支払日のバリデーション_数値はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100,
            'account_date' => 1
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['account_date' => trans('account.errors.date.date')]);
    }

    /** @test */
    public function 支払日のバリデーション_配列はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100,
            'account_date' => ['2023-07-01'],
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['account_date' => trans('account.errors.date.date')]);
    }

    /** @test */
    public function 支払日のバリデーション_存在しない日付はNG(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100,
            'account_date' => '2023-06-31'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertRedirect(route('account.create'))
            ->assertInvalid(['account_date' => trans('account.errors.date.date')]);
    }

    /** @test */
    public function 支払日のバリデーション_存在する日付はOK(): void
    {
        $user  = User::factory()->create();
        $param = [
            'name' => str_repeat('あ', 1),
            'amount' => 100000,
            'account_date' => '2023-07-01'
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->from(route('account.create'));
        $this->post($url, $param)
            ->assertValid('account_date');
    }
}
