<?php

namespace App\Filament\Resources\PimpinanOrganisasiDesaResource\RelationManagers;

use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Sabberworm\CSS\Position\Positionable;

class AnggotaOrganisasiDesaRelationManager extends RelationManager
{
    protected static string $relationship = 'anggotaOrganisasiDesa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->extraInputAttributes(['onChange' => 'this.value = this.value.toUpperCase()'])
                    ->maxLength(255),
                Forms\Components\Select::make('posisi')
                    ->options(Position::query()->pluck('posisi', 'posisi')) // Ubah dari 'id' ke 'posisi'
                    ->required()
                    ->native(false)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('posisi')
                            ->required(),
                    ])
                    ->createOptionUsing(function ($data) {
                        // Simpan ke tabel positions untuk referensi dropdown
                        Position::firstOrCreate(['posisi' => $data['posisi']]);

                        // Return nama posisi (bukan ID)
                        return $data['posisi']; // Ini yang akan disimpan di field 'posisi'
                    })
                    ->searchable(),
                Forms\Components\TextInput::make('periode_awal')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2100),
                Forms\Components\TextInput::make('periode_akhir')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2100),
                Forms\Components\TextInput::make('pengalaman')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('fokus')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_telepon')
                    ->required()
                    ->prefixIcon('heroicon-m-phone')
                    ->prefixIconColor('success')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\Select::make('organisasi')
                    ->options([
                        'Pemerintahan Desa' => 'Pemerintahan Desa',
                        'BPD' => 'Badan Permusyawaratan Desa',
                        'LPMD' => 'Lembaga Pemberdayaan Masyarakat Desa',
                        'PKK' => 'Pembinaan Kesejahteraan Keluarga',
                        'Karang Taruna' => 'Karang Taruna',
                        'Lembaga Adat' => 'Lembaga Adat',
                    ])
                    ->required()
                    ->native(false)
                    ->searchable(),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper(),
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
