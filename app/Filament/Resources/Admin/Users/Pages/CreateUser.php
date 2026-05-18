<?php

namespace App\Filament\Resources\Admin\Users\Pages;

use App\Filament\Resources\Admin\Users\Schemas\UserForm;
use App\Filament\Resources\Admin\Users\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components($this->getFormComponents());
    }

    protected function getFormComponents(): array
    {
        return [
            Tabs::make()
                ->tabs([
                    Tabs\Tab::make('مشخصات کاربر')
                        ->schema(UserForm::components()),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull(),

        ];
    }
    public function getCreatedNotification():?Notification
    {
        return Notification::make()
            ->success()
            ->title('ایجاد کاربر')
            ->body('کاربر با موفقیت ایجاد شد');
    }

    public function getRedirectUrl():string
    {
        return $this->getResourceUrl('index');
    }
}
