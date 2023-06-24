<?php

namespace App\Console\Commands;

use App\Models\MailAccount;
use App\Models\User;
use App\Services\DecryptService;
use App\Services\ImapService;
use App\Services\MailAccountService;
use Illuminate\Console\Command;

class MailAccountRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mail-account-register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '登録されたメールアドレスから明細を取得して登録する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with('mailConnections')->get();
        foreach ($users as $user) {
            $connections = $user->mailConnections;
            foreach ($connections as $connection) {
                
                $password = DecryptService::execDecrypt($connection->cipher_password);
                $bodies    = ImapService::getMailBodys($connection, $password);
                $accounts = MailAccountService::getMailAccounts($bodies);
                
                foreach($accounts as $account) {
                    
                    MailAccount::create([
                        'user_id' => $connection->user_id,
                        'name'    => $account['name'],
                        'amount'  => $account['amount'],
                        'date'    => $account['date'],
                    ]);
                }
            }
        }
    }
}
