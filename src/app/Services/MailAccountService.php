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
        $targetBody = \Config('const.mail_account.target_start_body');

        foreach($bodies as $body) {
            $bodyArray = explode("\n", $body);
            $key       = array_search($targetBody, $bodyArray, true);
            $result    = array_merge($result, self::getAccounts($key, $bodyArray));
        }

        return $result;
    }

    /**
     * メール本文から明細情報を取得する
     * 
     * @param int   $key       明細情報の一つ前の行番号
     * @param array $bodyArray 改行区切りで配列にした本文
     * 
     * @return array 明細情報
     */
    private static function getAccounts(int $key, array $bodyArray): array
    {
        $accounts = [];
        while ($key++) {
            if (mb_strpos($bodyArray[$key], \Config('const.mail_account.target_end_body'))) {
                break;
            }
            $account           = [];
            $accountArray      = explode(' ', $bodyArray[$key]);
            $account['date']   = self::getDate($accountArray);
            $afterNameKey      = self::getAfeterNameKey($accountArray);
            $account['name']   = self::getName($afterNameKey, $accountArray);
            $account['amount'] = self::getAmount($afterNameKey, $accountArray);
            $accounts[]        = $account;
        }
        return $accounts;
    }

    /**
     * 支出発生日を取得する
     * 
     * @param array $bodyArray 改行区切りで配列にした本文
     * 
     * @return string 支出発生日
     */
    private static function getDate(array $accountArray): string
    {
        $date = new Carbon($accountArray[\Config('const.mail_account.body_date_index')]);
        return $date->toDateString();
    }

    /**
     * 支出項目名の次の行番号を取得する
     * 
     * @param array $bodyArray 改行区切りで配列にした本文
     * 
     * @return int 支出項目名の次の行番号
     */
    private static function getAfeterNameKey(array $accountArray): int
    {
        if (array_search(\Config('const.mail_account.after_name_value_master'), $accountArray, true)) {
            $result = array_search(\Config('const.mail_account.after_name_value_master'), $accountArray, true);
        } else {
            $result = array_search(\Config('const.mail_account.after_name_value_not_master'), $accountArray, true);
        }

        return $result;
    }

    /**
     * 支出項目名を取得する
     * 
     * @param int   $afterNameKey 支出項目名の次の行番号
     * @param array $bodyArray 改行区切りで配列にした本文
     * 
     * @return string 支出項目名
     */
    private static function getName(int $afterNameKey, array $accountArray): string
    {
        $name = '';
        for ($i = \Config('const.mail_account.body_name_start_index'); $i < $afterNameKey; $i++) {
            $name .= $accountArray[$i];
        }

        return trim($name);
    }

    /**
     * 支出金額を取得する
     * 
     * @param int   $afterNameKey 支出項目名の次の行番号
     * @param array $bodyArray 改行区切りで配列にした本文
     * 
     * @return int 支出金額
     */
    private static function getAmount(int $afterNameKey, array $accountArray): int
    {
        $amount = $accountArray[$afterNameKey + \Config('const.mail_account.body_amount_index_from_master')];
        return str_replace(',', '', $amount);
    }
}