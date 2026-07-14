<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContractInterface;

enum PaymentGateways: string implements Contracts\EnumContractInterface
{
    case ZARINPAL = '1';

    case OMIDPAY = '2';
    public static function labels(): array
    {
        return [
            self::ZARINPAL->value => 'زرین پال',
            self::OMIDPAY->value => 'امیدپی',
        ];
    }

    public static function englishLabels(): array
    {
        return [
            self::ZARINPAL->value => 'zarinpal',
            self::ZARINPAL->value => 'omidpay',
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
