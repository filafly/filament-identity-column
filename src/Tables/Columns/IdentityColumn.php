<?php

namespace Filafly\IdentityColumn\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class IdentityColumn extends TextColumn
{
    protected string $view = 'filafly-identity-column::columns.identity-column';

    public static function make(?string $name = null): static
    {
        $column = parent::make($name);

        $column
            ->label('ID')
            ->sortable()
            ->searchable()
            ->toggleable(isToggledHiddenByDefault: false);

        return $column;
    }
}
