<?php

namespace App\Enums;

enum StoreType: int
{
    // 基本情報
    case Mail   = 1;
    case Manual = 2;

    // 日本語を追加
    public function label(): string
    {
        return match($this)
        {
            StoreType::Mail   => 'メール',
            StoreType::Manual => '手動',
        };
    }
}