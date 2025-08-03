<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendaDesaResource\Pages;
use App\Filament\Resources\AgendaDesaResource\RelationManagers;
use App\Models\AgendaDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgendaDesaResource extends Resource
{
    protected static ?string $model = AgendaDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul_kegiatan')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_kegiatan')
                    ->required()
                    ->label('Tanggal Kegiatan Dilaksanakan')
                    ->native(false)
                    ->locale('id')
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('D, d M Y'),
                Forms\Components\TimePIcker::make('waktu_mulai_kegiatan')
                    ->required()
                    ->label('Waktu Mulai Kegiatan')
                    ->native(false)
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('H:i')
                    ->default(Carbon::now()),
                Forms\Components\TimePicker::make('waktu_selesai_kegiatan')
                    ->required()
                    ->label('Waktu Selesai Kegiatan')
                    ->native(false)
                    ->timezone('Asia/Jakarta')
                    ->displayFormat('H:i'),
                Forms\Components\TextInput::make('tempat_kegiatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penyelenggara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('peserta')
                    ->maxLength(255),
                Forms\Components\Select::make('tipe_kegiatan')
                    ->required()
                    ->label(__('Tipe Kegiatan'))
                    ->options([
                        'meeting' => 'Rapat',
                        'social' => 'Sosial',
                        'development' => 'Pembangunan',
                        'training' => 'Pembangunan',
                    ])
                    ->native(false),
                Forms\Components\Textarea::make('deskripsi_kegiatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_kegiatan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waktu_mulai_kegiatan'),
                Tables\Columns\TextColumn::make('waktu_selesai_kegiatan'),
                Tables\Columns\TextColumn::make('tempat_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penyelenggara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('peserta')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgendaDesas::route('/'),
            'create' => Pages\CreateAgendaDesa::route('/create'),
            'edit' => Pages\EditAgendaDesa::route('/{record}/edit'),
        ];
    }
}
