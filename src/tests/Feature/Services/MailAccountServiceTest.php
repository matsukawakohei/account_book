<?php

namespace Tests\Feature\Services;

use App\Services\MailAccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailAccountServiceTest extends TestCase
{
    /** @test */
    public function メール本文から明細に必要な文字列を取得する(): void
    {
        $bodies = [
            '━━━━━━━━━━
            カード利用お知らせメール
            ━━━━━━━━━━
            楽天カードを装った不審なメールにご注意ください
            https://r10.to/hONHt2
            
            楽天カード（Visa）をご利用いただき誠にありがとうございます。
            お客様のカード利用情報が弊社に新たに登録されましたのでご案内いたします。
            カード利用お知らせメールは、加盟店から楽天カードのご利用データが弊社に
            到着した原則2営業日後にご指定のメールアドレスへ通知するサービスです。
            
            
            <カードご利用情報>
            《ショッピングご利用分》
            ■利用日: 2023/07/05
            ■利用先: 楽天ＳＰ　クリエイト　エス・デ
            ■利用者: 本人
            ■支払方法: 1回
            ■利用金額: 463 円
            ■支払月: 2023/08
            ■カード利用獲得ポイント:
            　4 ポイント
            ■ポイント獲得予定月:
            　2023/08
            
            ■利用日: 2023/07/09
            ■利用先: ﾋﾞﾋﾞｴｷﾂﾁﾝ
            ■利用者: 本人
            ■支払方法: 1回
            ■利用金額: 2,500 円
            ■支払月: 2023/08
            ■カード利用獲得ポイント:
            　25 ポイント
            ■ポイント獲得予定月:
            　2023/08
            
            ■利用日: 2023/07/09
            ■利用先: Ｓｕｉｃａ（携帯決済）
            ■利用者: 本人
            ■支払方法: 1回
            ■利用金額: 1,000 円
            ■支払月: 2023/08
            ■カード利用獲得ポイント:
            　-
            ■ポイント獲得予定月:
            　-
            
            ■ご利用明細のご確認
            https://r10.to/h30dgj
            ■ご利用可能額について
            https://r10.to/hZ2aGM
            ■後リボについて
            ショッピングご利用分のお支払い方法変更で、
            月々3,000円〜＋リボ手数料（包括信用購入あつせんの手数料）に！
            ※リボルビング払いのご利用可能額を超過してリボ払いのご利用はできません。
            https://r10.to/hEdEHL
            
            ≪カード利用お知らせメール掲載ご利用分≫
            ■当月支払予定の1回払い
            　0件　0円
            ■翌月支払予定の1回払い
            　3件　3,963円
            ■分割/ボーナス払/リボ払い
            　0件　0円
            ■合計
            　3件　3,963円
            ■合計獲得予定ポイント数
            　29ポイント
            
            ◆万が一ご利用に覚えのない場合は、よくあるお問い合わせ事例をご確認ください。
            https://r10.to/hIvCVh
            
            ━━━━━━━━━━━
            ※自動リボサービスにご登録いただいた後のご利用分は、<<リボ払いへ変更できないショッピングご利用分>>のご利用一覧へ含まれております。なお、自動リボサービスにご登録にいただいている場合であっても、割賦枠を超えたご利用分は、リボ払いではなく1回払いとなります。
            （お客様のご利用可能額のご確認はこちら）
            https://r10.to/hslzGm
            ※カードの年会費・分割払い(3〜36回)・ボーナス2回払いのご利用分や家賃のお支払いなど一部の加盟店のご利用分については、リボ払いへの変更はできません。
            ※カード利用獲得ポイントは当月ご利用分の合計金額の1％分の楽天ポイントを進呈いたします。
            ※カード利用獲得ポイントはカードショッピングの利用金額の1％で表示しています。
            ※カード利用獲得ポイントの予定数です。
            ※auかんたん決済ご利用によるEdyチャージ分、楽天キャッシュ、キャッシングご利用分はポイント獲得の対象外となります。
            ※2014年12月1日(月)以降のEdyチャージ分より、「カード利用獲得ポイント」の対象となりました。
            ※Edyチャージご利用分は200円ごとに1ポイントたまります。
            
            ※メールアドレスにご変更がある場合は、こちらからご変更ください。
            https://r10.to/hvLsOc
            
            ━━━━━━━━━━━
            ◆ご注意
            本メールはキャンセル・取消のご案内については配信されません。
            ◆ご利用可能枠の増枠は下記よりお手続きください。
            https://r10.to/hM4ZVE
            また、お客様情報が正しく登録されていないと、適正な利用可能枠を付帯できない場合がございますので下記よりご確認ください。
            https://r10.to/hrPxTB
            
            ━━━━━━━━━━━
            安心してカードをご利用いただくために
            ━━━━━━━━━━━
            カード利用お知らせメールのほかに、セキュリティに関するさまざまなサービスやコンテンツをご用意しております。
            こちらもぜひご利用ください。
            
            ◆トラブル事例を知る
            https://r10.to/h6AaGY
            
            ◆本人認証サービス
            https://r10.to/hzPuTM
            
            ━━━━━━━━━━━
            楽天カードの取り組み
            ━━━━━━━━━━━
            お客様より頂戴したご意見・ご要望の一つひとつを真摯に受け止め、さらなる安心と信頼をご提供できるよう、日々改善に取り組んでおります。
            ※フィーチャーフォンからはご参照いただけません。
            
            ◆お客様の声への取り組みについてはこちら
            https://r10.to/hsgGv4
            
            ━━━━━━━━━━━
            このメールは配信専用です
            発行元 楽天カード株式会社
            https://www.rakuten-card.co.jp/',
        ];

        $result = MailAccountService::getMailAccounts($bodies);

        $expect = [
            [
                'date'   => '2023-07-05',
                'name'   => '楽天ＳＰ　クリエイト　エス・デ',
                'amount' => 463,
            ],
            [
                'date'   => '2023-07-09',
                'name'   => 'ﾋﾞﾋﾞｴｷﾂﾁﾝ',
                'amount' => 2500,
            ],
            [
                'date'   => '2023-07-09',
                'name'   => 'Ｓｕｉｃａ（携帯決済）',
                'amount' => 1000,
            ],
        ];

        $this->assertSame($expect, $result);
    }
}
