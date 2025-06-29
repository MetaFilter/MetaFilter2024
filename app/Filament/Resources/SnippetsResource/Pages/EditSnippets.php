<?php

declare(strict_types=1);

namespace App\Filament\Resources\SnippetsResource\Pages;

use App\Filament\Resources\SnippetResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;

final class EditSnippets extends EditRecord
{
    protected static string $resource = SnippetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
