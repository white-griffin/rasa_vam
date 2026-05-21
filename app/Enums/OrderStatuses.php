<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContractInterface;

enum OrderStatuses: string implements Contracts\EnumContractInterface
{

    case PENDING = '1';
    case PAID = '2';
    case CANCELLED = '3';
    case FAILED = '4';

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'در انتظار',
            self::PAID->value => 'موفق',
            self::CANCELLED->value => 'لغو شده',
            self::FAILED->value => 'نا موفق',
        ];
    }

    public static function englishLabels(): array
    {
        return [
            self::PENDING->value => 'pending',
            self::PAID->value => 'paid',
            self::CANCELLED->value => 'cancelled',
            self::FAILED->value => 'failed',
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
