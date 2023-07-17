<?php

namespace Tests\Feature;

use App\Enums\StoreType;
use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 一覧表示のテスト(): void
    {
        $user     = User::factory()->create();
        $user2    = User::factory()->create();
        Account::create([
            'user_id'    => $user->id,
            'name'       => '明細1',
            'amount'     => 1000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);
        Account::create([
            'user_id'    => $user->id,
            'name'       => '明細2',
            'amount'     => 2000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);
        Account::create([
            'user_id'    => $user2->id,
            'name'       => '明細3',
            'amount'     => 3000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $this->actingAs($user);
        $url = route('account.index');
        $this->get($url)
            ->assertOk()
            ->assertSee('明細1')
            ->assertSee('明細2')
            ->assertSee('3,000')
            ->assertSee('2,000')
            ->assertDontSee('明細3');
    }

    /** @test */
    public function 一覧表示のテスト_リダイレクト():void
    {
        $url = '/';
        $this->get($url)
            ->assertRedirect(route('account.index'));
    }

    /** @test */
    public function 一覧表示のテスト_ログインなし(): void
    {
        $url = route('account.index');
        $this->get($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 登録画面のテスト(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $url = route('account.create');
        $this->get($url)
            ->assertOk()
            ->assertSee('支出登録');
    }

    /** @test */
    public function 登録画面のテスト_ログインなし(): void
    {
        $url = route('account.create');
        $this->get($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 登録のテスト(): void
    {
        $user = User::factory()->create();
        $param = [
            'name'          => '明細4',
            'amount'        => 4000,
            'account_date'  => Carbon::now()->toDateString(),
        ];
        $expect = [
            'user_id'    => $user->id,
            'name'       => '明細4',
            'amount'     => 4000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ];

        $this->actingAs($user);
        $url = route('account.store');
        $this->post($url, $param)
            ->assertRedirect(route('account.index'));
        
        $this->assertDatabaseHas('accounts', $expect);

        $this->get(route('account.index'))
            ->assertSee('支出の登録が完了しました。');
    }

    /** @test */
    public function 登録のテスト_ログインなし(): void
    {
        $url = route('account.store');
        $this->post($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 更新画面のテスト(): void
    {
        $user    = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細5',
            'amount'     => 5000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $this->actingAs($user);
        $url = route('account.edit', $account);
        $this->get($url)
            ->assertOk()
            ->assertSee('支出編集')
            ->assertSee('明細5');
    }

    /** @test */
    public function 更新画面のテスト_明細のユーザーとログインユーザーが別の場合(): void
    {
        $user    = User::factory()->create();
        $user2   = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細5',
            'amount'     => 5000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $this->actingAs($user2);
        $url = route('account.edit', $account);
        $this->get($url)
            ->assertRedirect(route('account.index'));

        $this->get(route('account.index'))
            ->assertSee('無効な明細が選択されました。');
    }

    /** @test */
    public function 更新画面のテスト_ログインなし(): void
    {
        $user    = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細5',
            'amount'     => 5000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $url = route('account.edit', $account);
        $this->get($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 更新のテスト(): void
    {
        $user    = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細6',
            'amount'     => 6000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);
        $param  = [
            'name'         => '明細6_変更',
            'amount'       => 6500,
            'account_date' => Carbon::now()->toDateString(),
        ];
        $expect = [
            'user_id'      => $user->id,
            'name'         => '明細6_変更',
            'amount'       => 6500,
            'date'         => Carbon::now()->toDateString(),
            'store_type'   => StoreType::Manual,
        ];

        $this->actingAs($user);
        $url = route('account.update', $account);
        $this->put($url, $param)
            ->assertRedirect(route('account.edit', $account));

        $this->assertDatabaseHas('accounts', $expect);

        $this->get(route('account.edit', $account))
            ->assertSee('支出の更新が完了しました。');
    }

    /** @test */
    public function 更新のテスト_明細のユーザーとログインユーザーが別の場合(): void
    {
        $user    = User::factory()->create();
        $user2   = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細6',
            'amount'     => 6000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);
        $param  = [
            'name'         => '明細6_変更',
            'amount'       => 6500,
            'account_date' => Carbon::now()->toDateString(),
        ];

        $this->actingAs($user2);
        $url = route('account.update', $account);
        $this->put($url, $param)
            ->assertRedirect(route('account.index'));

        $this->get(route('account.index'))
            ->assertSee('無効な明細が選択されました。');
    }

    /** @test */
    public function 更新のテスト_ログインなし(): void
    {
        $user    = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細5',
            'amount'     => 5000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $url = route('account.update', $account);
        $this->put($url)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function 削除のテスト(): void
    {
        $user    = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細7',
            'amount'     => 7000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $this->actingAs($user);
        $url = route('account.delete', $account);
        $this->delete($url)
            ->assertRedirect(route('account.index', ['date' => Carbon::now()->toDateString()]));

        $this->assertSoftDeleted($account);

        $this->get(route('account.index'))
            ->assertSee('支出の削除が完了しました。');
    }

    /** @test */
    public function 削除のテスト_明細のユーザーとログインユーザーが別の場合(): void
    {
        $user    = User::factory()->create();
        $user2   = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細6',
            'amount'     => 6000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $this->actingAs($user2);
        $url = route('account.delete', $account);
        $this->delete($url)
            ->assertRedirect(route('account.index'));

        $this->get(route('account.index'))
            ->assertSee('無効な明細が選択されました。');
    }

    /** @test */
    public function 削除のテスト_ログインなし(): void
    {
        $user    = User::factory()->create();
        $account = Account::create([
            'user_id'    => $user->id,
            'name'       => '明細5',
            'amount'     => 5000,
            'date'       => Carbon::now()->toDateString(),
            'store_type' => StoreType::Manual,
        ]);

        $url = route('account.delete', $account);
        $this->delete($url)
            ->assertRedirect(route('login'));
    }
}
