<?php

namespace App\Services;

use App\Models\MailConnection;
use IMAP\Connection;
use stdClass;

class ImapService
{
    /**
     * 与えらたメール接続情報から指定された件名のメールの本文を取得する
     * 
     * @param MailConnection $mailConnection MailConnectionモデルのインスタンス
     * @param string         $password       メールアドレスのパスワード
     * 
     * @return array メール本文の配列
     */
    public static function getMailBodys(MailConnection $mailConnection, string $password): array
    {
        $mailbox = '{' .$mailConnection->host .':' .$mailConnection->port .'/imap/ssl}' .$mailConnection->mail_box;
        $imapConnection = imap_open($mailbox, $mailConnection->email, $password);

        if ($imapConnection === false) {
            return [];
        }

        $bodys = [];
        $messageNumbers = imap_search($imapConnection, 'UNSEEN');
        foreach($messageNumbers as $messageNumber) {
            $subject = self::getSubject($imapConnection, $messageNumber);
            if ($subject !== $mailConnection->subject) {
                continue;
            }

            $bodys[] = self::getBody($imapConnection, $messageNumber);
            
        }
        imap_close($imapConnection);

        return $bodys;
    }

    /**
     * 件名を取得する
     * 
     * @param Connection $imapConnection IMAPの接続インスタンス
     * @param string     $messageNumber  メールのメッセージNo.
     * 
     * @return string メールの件名
     */
    private static function getSubject(Connection $imapConnection, string $messageNumber): string
    {
        $header = imap_headerinfo($imapConnection, $messageNumber);
        if (!isset($header->subject)) {
            return '';
        }
        
        $mailHeader = imap_mime_header_decode($header->subject);

        $subject = '';
        foreach($mailHeader as $value) {
            if($value->charset == 'default') {
                $subject .= $value->text;
            } else {
                $subject .= mb_convert_encoding($value->text, 'UTF-8', $value->charset);
            }
        }
        return $subject;
    }

    /**
     * 本文を取得する
     * 
     * @param Connection $imapConnection IMAPの接続インスタンス
     * @param string     $messageNumber  メールのメッセージNo.
     * 
     * @return string メールの本文
     */
    private static function getBody(Connection $imapConnection, string $messageNumber): string
    {
        $body = imap_fetchbody($imapConnection, $messageNumber, 1, FT_INTERNAL);
        $bodyStructure = imap_fetchstructure($imapConnection, $messageNumber);

        if (isset($bodyStructure->parts)) {
            $charset  = $bodyStructure->parts[0]->parameters[0]->value;
            $encoding = $bodyStructure->parts[0]->encoding;
        } else {
            $charset  = $bodyStructure->parameters[0]->value;
            $encoding = $bodyStructure->encoding;
        }

        switch ($encoding) {
            case ENC8BIT:
                $body = imap_8bit($body);
                $body = imap_qprint($body);
                break;
            case ENCBASE64:
                $body = imap_base64($body);
                break;
            case ENCQUOTEDPRINTABLE:
                $body = imap_qprint($body);
                break;
            case ENC7BIT:
            case ENCBINARY:
            case ENCOTHER:
            default:
        }
        
        $body = mb_convert_encoding($body, 'UTF-8', $charset);
        return str_replace(["\r\n", "\r"], "\n", $body);;
    }
}