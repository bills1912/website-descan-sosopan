<?php

namespace App\Filament\Resources\TahunAnggaranAPBDesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DataAnggaranAPBDesRelationManager extends RelationManager
{
    protected static string $relationship = 'dataAnggaranAPBDes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Hasil Usaha')
                    ->schema([
                        Forms\Components\TextInput::make('hasil_usaha_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('hasil_usaha_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('hasil_usaha_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Hasil Aset')
                    ->schema([
                        Forms\Components\TextInput::make('hasil_aset_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('hasil_aset_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('hasil_aset_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Swadaya, Partisipasi, Gotong Royong')
                    ->schema([
                        Forms\Components\TextInput::make('swadaya_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('swadaya_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('swadaya_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Dana Desa')
                    ->schema([
                        Forms\Components\TextInput::make('dana_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('dana_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('dana_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Bagi Hasil Pajak')
                    ->schema([
                        Forms\Components\TextInput::make('bagi_hasil_pajak_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('bagi_hasil_pajak_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('bagi_hasil_pajak_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Alokasi Dana Desa')
                    ->schema([
                        Forms\Components\TextInput::make('alokasi_dana_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('alokasi_dana_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('alokasi_dana_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Bantuan Keuangan Kabupaten')
                    ->schema([
                        Forms\Components\TextInput::make('bantuan_keuangan_kab_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('bantuan_keuangan_kab_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('bantuan_keuangan_kab_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Bantuan Keuangan Provinsi')
                    ->schema([
                        Forms\Components\TextInput::make('bantuan_keuangan_prov_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('bantuan_keuangan_prov_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('bantuan_keuangan_prov_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Hibah')
                    ->schema([
                        Forms\Components\TextInput::make('hibah_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('hibah_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('hibah_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Sumbangan Pihak Ketiga')
                    ->schema([
                        Forms\Components\TextInput::make('sumbangan_pihak_ketiga_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('sumbangan_pihak_ketiga_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('sumbangan_pihak_ketiga_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Pendapatan Lain-Lain')
                    ->schema([
                        Forms\Components\TextInput::make('pendapatan_lain_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('pendapatan_lain_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('pendapatan_lain_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Penyelenggaraan Pemerintahan Desa')
                    ->schema([
                        Forms\Components\TextInput::make('penyelenggaraan_pemerintahan_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('penyelenggaraan_pemerintahan_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('penyelenggaraan_pemerintahan_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Pelaksanaan Pembangunan Desa')
                    ->schema([
                        Forms\Components\TextInput::make('pelaksanaan_pembangunan_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('pelaksanaan_pembangunan_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('pelaksanaan_pembangunan_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Pembinaan Kemasyarakatan Desa')
                    ->schema([
                        Forms\Components\TextInput::make('pembinaan_kemasyarakatan_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('pembinaan_kemasyarakatan_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('pembinaan_kemasyarakatan_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Pemberdayaan Masyarakat Desa')
                    ->schema([
                        Forms\Components\TextInput::make('pemberdayaan_masyarakat_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('pemberdayaan_masyarakat_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('pemberdayaan_masyarakat_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Belanja Tak Terduga')
                    ->schema([
                        Forms\Components\TextInput::make('belanja_tak_terduga_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('belanja_tak_terduga_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('belanja_tak_terduga_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Silpa')
                    ->schema([
                        Forms\Components\TextInput::make('silpa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('silpa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('silpa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Pencairan Dana Cadangan')
                    ->schema([
                        Forms\Components\TextInput::make('pencairan_dana_cadangan_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('pencairan_dana_cadangan_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('pencairan_dana_cadangan_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Hasil Penjualan Kekayaan Desa')
                    ->schema([
                        Forms\Components\TextInput::make('hasil_penjualan_kekayaan_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('hasil_penjualan_kekayaan_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('hasil_penjualan_kekayaan_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Pembentukan Dana Cadangan')
                    ->schema([
                        Forms\Components\TextInput::make('pembentukan_dana_cadangan_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('pembentukan_dana_cadangan_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('pembentukan_dana_cadangan_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
                Forms\Components\Fieldset::make('Penyertaan Modal Desa')
                    ->schema([
                        Forms\Components\TextInput::make('penyertaan_modal_desa_rencana')
                            ->label('Rencana/Anggaran')
                            ->numeric(),
                        Forms\Components\TextInput::make('penyertaan_modal_desa_realisasi')
                            ->label('Realisasi')
                            ->numeric(),
                        Forms\Components\TextInput::make('penyertaan_modal_desa_sisa')
                            ->label('Lebih/Kurang')
                            ->numeric(),
                    ])
                    ->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
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
