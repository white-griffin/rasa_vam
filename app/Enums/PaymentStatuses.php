<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContractInterface;

enum PaymentStatuses:string implements Contracts\EnumContractInterface
{

    case PENDING = '1';
    case REDIRECTED = '2';
    case SUCCESS = '3';
    case FAILED = '4';
    case CANCELLED = '5';
    case REVERSED = '6';

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'در انتظار',
            self::REDIRECTED->value => 'منتقل شده',
            self::SUCCESS->value => 'موفق',
            self::FAILED->value => 'نا موفق',
            self::CANCELLED->value => 'لغو شده',
            self::REVERSED->value => 'برگشت خورده',
        ];
    }

    public static function englishLabels(): array
    {
        return [
            self::PENDING->value => 'pending',
            self::REDIRECTED->value => 'redirect',
            self::SUCCESS->value => 'success',
            self::FAILED->value => 'failed',
            self::CANCELLED->value => 'cancelled',
            self::REVERSED->value => 'reversed',
        ];
    }

    public static function label(string $value): ?string
    {
        return self::labels()[$value] ?? null;
    }

    public static function fromValue(string $value): ?self
    {
        return self::from($value);
    }

    public static function toKeyValueItems(): ?array
    {
        return array_map(
            fn($label, $value) => ['value' => $value, 'label' => $label],
            self::labels(),
            array_keys(self::labels())
        );
    }
}
