<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportPublicationDataResource\Pages;
use App\Filament\Resources\ReportPublicationDataResource\RelationManagers;
use App\Models\ReportPublicationData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportPublicationDataResource extends Resource
{
    protected static ?string $model = ReportPublicationData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('waktu_terbit')
                    ->required()
                    ->native(false)
                    ->locale('id')
                    ->timezone('Asia/Jakarta')
                    ->default(now()),
                Forms\Components\Select::make('kategori')
                    ->required()
                    ->options([
                        'annual_report' => 'Laporan Tahunan',
                        'financial_report' => 'Laporan Keuangan',
                        'demographic_data' => 'Data Demografi',
                        'health_data' => 'Data Kesehatan',
                        'education_data' => 'Data Pendidikan',
                        'economic_data' => 'Data Ekonomi',
                        'village_profile' => 'Profil Desa',
                        'development_report' => 'Laporan Pembangunan',
                        'other' => 'Lainnya'
                    ])
                    ->default('Lainnya'),
                Forms\Components\FileUpload::make('file_path')
                    ->required()
                    ->disk('public')
                    ->directory('reports')
                    ->visibility('public'),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('waktu_terbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
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
            'index' => Pages\ListReportPublicationData::route('/'),
            'create' => Pages\CreateReportPublicationData::route('/create'),
            'edit' => Pages\EditReportPublicationData::route('/{record}/edit'),
        ];
    }
}
