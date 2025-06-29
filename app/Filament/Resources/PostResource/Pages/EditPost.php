<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('publish')
            ->label('Publish')
            ->visible(fn(Post $record) => $record->is_published === false)
            ->action(function (Post $record) {
                $record->setLive();
                $record->save();
            })
            ->after(function () {
                $this->refreshFormData(['is_published', 'published_at']);
            }),
            Action::make('unpublish')
            ->label('Unpublish')
            ->visible(fn(Post $record) => $record->is_published === true)
            ->action(function (Post $record) {
                $record->is_published = false;
                $record->save();
            })
            ->after(function () {
                $this->refreshFormData(['is_published', 'published_at']);
            }),

        ];
    }
}
