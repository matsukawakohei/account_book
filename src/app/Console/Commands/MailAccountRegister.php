<?php

namespace App\Console\Commands;

use App\Models\MailAccount;
use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;

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
        $users = User::all();
        // 暗号化方式に応じたIV(初期化ベクトル)に必要な長さを取得
        $ivLength = openssl_cipher_iv_length(\Config('const.mail_connection.encrypt_tyep'));
        // IV を自動生成
        $iv = openssl_random_pseudo_bytes($ivLength);
        foreach ($users as $user) {
            $connections = $user->mailConnections;
            foreach ($connections as $connection) {
                $cfg['GMAIL_ACCOUNT'] = $connection->email;
                $c = base64_decode($connection->ciphertext);
                $ivlen = openssl_cipher_iv_length(\Config('const.mail_connection.encrypt_tyep'));
                $iv = substr($c, 0, $ivlen);
                $hmac = substr($c, $ivlen, $sha2len=32);
                $ciphertextRaw = substr($c, $ivlen+$sha2len);
                $password = openssl_decrypt(
                    $ciphertextRaw,
                    \Config('const.mail_connection.encrypt_tyep'),
                    \Config('const.mail_connection.encrypt_password'),
                    \Config('const.mail_connection.encrypt_options'),
                    $iv
                );
                $calcmac = hash_hmac('sha256', $ciphertextRaw, \Config('const.mail_connection.encrypt_password'), $as_binary=true);
                if (hash_equals($hmac, $calcmac)){
                    continue;
                }
                $cfg['GMAIL_PASSWORD'] = $password;
                //Gmailの接続情報
                $cfg['MAILBOX'] = '{' .$connection->host .':' .$connection->port .'/imap/ssl}INBOX';
                
                $accounts = [];
                if (($mbox = imap_open($cfg['MAILBOX'], $cfg['GMAIL_ACCOUNT'], $password)) === false) {
                    echo 'Gmailへの接続に失敗しました';
                } else {
                    echo '接続完了' ."\n";
                    //未読のみ取得する場合
                    $mails = imap_search($mbox, 'UNSEEN');
                    foreach($mails as $msgno) {
                        //メールのヘッダー情報を取得
                        $header = imap_headerinfo($mbox, $msgno);
                        //メールのタイトルを取得
                        $subject = $this->getSubject($header);
                        if ($subject !== $connection->subject) {
                            imap_delete($mbox, $msgno);
                        }
                        $body = $this->getBody($mbox, $msgno);
                        $searchSubject = \Config('const.mail_account.search_subject');
                        $bodyArray = explode("\n", $body);
                        $key = array_search($searchSubject, $bodyArray, true);
                        while ($key++) {
                            $accountArray = explode(' ', $bodyArray[$key]);
                            if (count($accountArray) !== \Config('const.mail_account.element_num')) {
                                break;
                            }
                            $accounts[] = $accountArray;
                        }
                    }
                    imap_close($mbox, CL_EXPUNGE);
                }
                foreach($accounts as $account) {
                    $date = new Carbon($account[\Config('const.mail_account.body_date_index')]);
                    MailAccount::create([
                        'user_id' => $connection->user_id,
                        'name'    => $account[\Config('const.mail_account.body_name_index')],
                        'amount'  => str_replace(',', ' ', $account[\Config('const.mail_account.body_amount_index')]),
                        'date'    => $date->toDateString(),
                    ]);
                }
            }
        }
    }

    function getSubject($header)
    {
        if (!isset($header->subject)) {
            //タイトルがない場合もある
            return '';
        }
        // タイトルをデコード
        $mhead = imap_mime_header_decode($header->subject);
        $subject = '';
        //タイトル部分は分割されているのでコード変換しながら結合する
        foreach($mhead as $key => $value) {
            if($value->charset == 'default') {
                $subject .= $value->text; //変換しない
            } else {
                $subject .= mb_convert_encoding($value->text, 'UTF-8', $value->charset);
            }
        }
        return $subject;
    }

    function getBody($mbox, $msgno)
    {
        //マルチパートだろうとそうでなかろうと1個目を取得する
        $body = imap_fetchbody($mbox, $msgno, 1, FT_INTERNAL);

        //メールの構造を取得
        $s = imap_fetchstructure($mbox, $msgno);

        //マルチパートのメールかどうか確認しつつ、文字コードとエンコード方式を確認
        if (isset($s->parts)) {
            //マルチパートの場合
            $charset = $s->parts[0]->parameters[0]->value;
            $encoding = $s->parts[0]->encoding;
        } else {
            //マルチパートではない場合
            $charset = $s->parameters[0]->value;
            $encoding = $s->encoding;
        }

        //エンコード方式に従いデコードする
        switch ($encoding) {
            case 1://8bit
                $body = imap_8bit($body);
                $body = imap_qprint($body);
                break;
            case 3://Base64
                $body = imap_base64($body);
                break;
            case 4: //Quoted-Printable
                $body = imap_qprint($body);
                break;
            case 0: //7bit
            case 2: //Binary
            case 5: //other
            default:
                //7bitやBinaryは何もしない
        }
        //メールの文字コードをUTF-8へ変換する
        $body = mb_convert_encoding($body, 'UTF-8', $charset);
        return str_replace(["\r\n", "\r"], "\n", $body);;
    }
}
