<?php

namespace App\Filament\Resources\KategoriProdukHukumResource\RelationManagers;

use App\Models\DaftarProdukHukum;
use App\Models\KategoriProdukHukum;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;

class DaftarProdukHukumsRelationManager extends RelationManager
{
    protected static string $relationship = 'daftarProdukHukums';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_dok')
                    ->required()
                    ->maxLength(255)
                    ->default(function (Livewire $livewire) {
                        if (isset($livewire->ownerRecord)) {
                            return $livewire->ownerRecord->slug . '-' . (DaftarProdukhukum::count() > 0 ? DaftarProdukhukum::count()+1 : 1);
                        }
                        return null;
                    })
                    ->readonly(),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun')
                    ->required()
                    ->maxLength(4)
                    ->numeric()
                    ->default(date('Y')),
                Forms\Components\TextInput::make('ukuran')
                    ->maxLength(50),
                Forms\Components\TextInput::make('tipe')
                    ->maxLength(50),
                Forms\Components\Textarea::make('deskripsi'), // Default value for the type of legal produc
                Forms\Components\FileUpload::make('dokumen')
                    ->required()
                    ->disk('public')
                    ->directory('dokumen_produk_hukum')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240) // 10 MB
                    ->visibility('public')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id_dok')
            ->columns([
                Tables\Columns\TextColumn::make('id_dok'),
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
