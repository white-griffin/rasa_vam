<?php

namespace App\Filament\Resources\Admin\LearningVideos\Tables;

use App\Enums\ActivityStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class LearningVideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')->label('عکس'),

                TextColumn::make('title')->label('عنوان'),

                TextColumn::make('slug')->label('اسلاگ'),

                TextColumn::make('activity_status')
                    ->label('وضعیت')
                    ->formatStateUsing(fn ($state) => ActivityStatus::label((string) $state) ?? '—')
                    ->badge()
                    ->colors([
                        'success'   => fn ($record) => (string) $record->activity_status === ActivityStatus::ACTIVE->value,
                        'danger' => fn ($record) => (string) $record->activity_status === ActivityStatus::INACTIVE->value,
                    ]),

            ])
            ->actions([
                Action::make('playVideo')
                    ->label('پخش') // متن دکمه
                    ->icon('heroicon-o-play') // آیکون دکمه
                    ->modalHeading('نمایش ویدیو') // عنوان Modal
                    ->modalContent(fn ($record): \Illuminate\Contracts\View\View => view('components.video-player', ['url' => $record->video_url])) // استفاده از پلیر ویدیوی شما
                    ->modalSubmitAction(false) // عدم نمایش دکمه ذخیره
                    ->modalCancelActionLabel('بستن'), // متن دکمه بستن
            ])

            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
