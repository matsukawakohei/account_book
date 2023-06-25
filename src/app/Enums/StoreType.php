<?php

namespace App\Enums;

enum StoreType: int
{
    // 基本情報
    case MAIL   = 1;
    case MANUAL = 2;

    // 日本語を追加
    public function label(): string
    {
        return match($this)
        {
            StoreType::MAIL   => 'メール',
            StoreType::MANUAL => '手動',
        };
    }
}