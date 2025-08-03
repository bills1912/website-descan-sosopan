<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KepalaKeluargaResource\Pages;
use App\Filament\Resources\KepalaKeluargaResource\RelationManagers;
use App\Models\KepalaKeluarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KepalaKeluargaResource extends Resource
{
    protected static ?string $model = KepalaKeluarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->required()
                    ->label(__('Jenis Kelamin'))
                    ->options([
                        '1' => 'Laki-Laki',
                        '2' => 'Perempuan',
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->locale('id')
                    ->live()
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('D, d M Y')
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('umur', Carbon::parse($state)->age);
                    })
                    ->native(false),
                Forms\Components\TextInput::make('umur')
                    ->readonly()
                    ->dehydrated(true)
                    ->numeric(),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_kk')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pendidikan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('umur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_kk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pendidikan')
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
            RelationManagers\FamilyMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKepalaKeluargas::route('/'),
            'create' => Pages\CreateKepalaKeluarga::route('/create'),
            'edit' => Pages\EditKepalaKeluarga::route('/{record}/edit'),
        ];
    }
}
