<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TahunAnggaranAPBDesResource\Pages;
use App\Filament\Resources\TahunAnggaranAPBDesResource\RelationManagers;
use App\Models\TahunAnggaranAPBDes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TahunAnggaranAPBDesResource extends Resource
{
    protected static ?string $model = TahunAnggaranAPBDes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun')
                    ->numeric()
                    ->maxLength(4),
                Forms\Components\TextInput::make('nama_petugas_keuangan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_petugas_keuangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DataAnggaranAPBDesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTahunAnggaranAPBDes::route('/'),
            'create' => Pages\CreateTahunAnggaranAPBDes::route('/create'),
            'edit' => Pages\EditTahunAnggaranAPBDes::route('/{record}/edit'),
        ];
    }
}
