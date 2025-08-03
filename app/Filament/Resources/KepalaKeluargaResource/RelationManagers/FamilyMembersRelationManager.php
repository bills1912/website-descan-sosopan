<?php

namespace App\Filament\Resources\KepalaKeluargaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FamilyMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'familyMembers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
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
                    ->native(false),
                Forms\Components\TextInput::make('umur')
                    ->numeric(),
                Forms\Components\Select::make('hubungan_dengan_kk')
                    ->required()
                    ->label(__('Hubungan dengan Kepala Keluarga'))
                    ->options([
                        '1' => 'Istri',
                        '2' => 'Anak Kandung',
                        '3' => 'Anak Tiri',
                    ])
                    ->native(false),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
