<?php

namespace App\Services;

use Carbon\Carbon;

class MailAccountService
{
    /**
     * メールの本文配列から明細情報を取得する
     * 
     * @param array $bodies メール本文の配列
     * 
     * @return array 明細情報の配列
     */
    public static function getMailAccounts(array $bodies): array
    {
        $result = [];

        foreach($bodies as $body) {
            $result = array_merge($result, self::getAccounts($body));
        }

        return $result;
    }

    /**
     * メール本文から明細情報を取得する
     * 
     * @param string $body 改行区切りで配列にした本文
     * 
     * @return array 明細情報
     */
    private static function getAccounts(string $body): array
    {
        $accounts = [];
        $start = 0;
        while ($dayOfPaymentPos = mb_strpos($body, config('const.mail_account.day_of_payment_word'), $start)) {
            $account = [];

            // 支払日
            $endPos          = mb_strpos($body, PHP_EOL, $dayOfPaymentPos);
            $dayOfPayment    = self::subStrAccountValue($body, $dayOfPaymentPos, $endPos);
            $account['date'] = self::getDateString($dayOfPayment);

            // 項目名
            $start           = $endPos;
            $accountNamePos  = mb_strpos($body, config('const.mail_account.account_name_word'), $start);
            $endPos          = mb_strpos($body, PHP_EOL, $accountNamePos);
            $account['name'] = self::subStrAccountValue($body, $accountNamePos, $endPos);

            // 金額
            $start             = $endPos;
            $amountPos         = mb_strpos($body, config('const.mail_account.amount_word'), $start);
            $endPos            = mb_strpos($body, PHP_EOL, $amountPos);
            $amount            = self::subStrAccountValue($body, $amountPos, $endPos);
            $account['amount'] = self::getAmountNum($amount);

            $accounts[] = $account;
        }

        return $accounts;
    }

    /**
     * メール本文から目的の文字列を抽出する
     * 
     * @param string $body     メール本文
     * @param int    $startPos 開始位置
     * @param int    $endPos   終了位置
     * 
     * @return string 抽出した文字列
     */
    private static function subStrAccountValue(string $body, int $startPos, int $endPos): string
    {
        $targetValue     = mb_substr($body, $startPos, ($endPos - $startPos));
        [, $targetValue] = explode(config('const.mail_account.separator'), $targetValue);
        
        return trim($targetValue);
    }

    /**
     * 日付形式を変更した文字列を返す
     * 
     * @param string $date 日付文字列
     * 
     * @return string 日付形式を変更した文字列
     */
    private static function getDateString(string $date): string
    {
        $carbon = new Carbon($date);

        return $carbon->toDateString();
    }

    /**
     * 金額の文字列から数字だけを抽出する(円とか,とかを削除する)
     * 
     * @param string $amount 金額の文字列
     * 
     * @return int 金額
     */
    private static function getAmountNum(string $amount): int
    {
        return preg_replace('/[^0-9]/u', '', $amount);
    }
}