<?php

namespace App\Filament\Resources\Admin\Users\Pages;


use App\Filament\Resources\Admin\Users\Schemas\UserForm;
use App\Filament\Resources\Admin\Users\Schemas\UserProfileForm;
use App\Filament\Resources\Admin\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class EditUser extends EditRecord
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

                    Tabs\Tab::make('پروفایل')
                        ->schema([
                            Group::make()
                                ->relationship('profile')
                                ->schema(UserProfileForm::components()),
                        ]),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull()
        ];
    }

    protected function beforeFill(): void
    {
        if (! $this->record->profile()->exists()) {
            $this->record->profile()->create();
            $this->record->refresh();
        }
    }

    public function getRedirectUrl(): string
    {
        return $this->getResourceUrl('index');
    }

    public function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('ویرایش کاربر')
            ->body('کاربر با موفقیت ویرایش شد');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
