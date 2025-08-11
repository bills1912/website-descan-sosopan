<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanDesaResource\Pages;
use App\Filament\Resources\KegiatanDesaResource\RelationManagers;
use App\Models\KegiatanDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KegiatanDesaResource extends Resource
{
    protected static ?string $model = KegiatanDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_kegiatan')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kegiatan')
                    ->required()
                    ->label(__('Jenis Kegiatan'))
                    ->options([
                        'sosial' => 'Sosial',
                        'ekonomi' => 'Ekonomi',
                        'pendidikan' => 'Pendidikan',
                        'kesehatan' => 'Kesehatan',
                        'lingkungan' => 'Lingkungan',
                        'infrastruktur' => 'Infrastruktur',
                    ])
                    ->native(false),
                Forms\Components\Textarea::make('deskripsi_kegiatan')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tanggal_kegiatan')
                    ->required()
                    ->label('Tanggal Kegiatan Dilaksanakan')
                    ->native(false)
                    ->locale('id')
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('D, d M Y'),
                Forms\Components\TextInput::make('lokasi_kegiatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penanggung_jawab')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file_path')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('kegiatanDesa')
                    ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penanggung_jawab')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKegiatanDesas::route('/'),
            'create' => Pages\CreateKegiatanDesa::route('/create'),
            'edit' => Pages\EditKegiatanDesa::route('/{record}/edit'),
        ];
    }
}
