<?php

namespace App\Filament\Imports;

use App\Models\Contact;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ContactImporter extends Importer
{
    protected static ?string $model = Contact::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('firstname')
                ->label('First Name')
                ->requiredMapping(),
            ImportColumn::make('lastname')
                ->label('Last Name')
                ->requiredMapping(),
            ImportColumn::make('email')
                ->label('Email')
                ->requiredMapping(),
            ImportColumn::make('phone')
                ->label('Phone')
                ->requiredMapping(),
            ImportColumn::make('language')
                ->label('Language')
                ->requiredMapping()
                ->rules(['in:de,fr,it']),
            ImportColumn::make("canton")
                ->label("Canton")
                ->requiredMapping(),
            ImportColumn::make("zip")
                ->requiredMapping()
                ->label("Zip"),
        ];
    }

    public function resolveRecord(): ?Contact
    {
        return Contact::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your contact import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
