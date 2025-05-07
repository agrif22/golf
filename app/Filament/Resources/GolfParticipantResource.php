<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GolfParticipantResource\Pages;
use App\Filament\Resources\GolfParticipantResource\RelationManagers;
use App\Models\GolfParticipant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;




class GolfParticipantResource extends Resource
{
    protected static ?string $model = GolfParticipant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('phone')->required(),
                Forms\Components\Select::make('play_time')
                    ->label('Waktu Main')
                    ->required()
                    ->options([
                        'pagi' => 'Pagi',
                        'siang' => 'Siang',
                        'ultra' => 'Ultra',
                    ])
                    ->placeholder('Pilih Waktu Main')
                    ->preload(),
                Forms\Components\FileUpload::make('document_path')
                    ->label('Dokumen PDF')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('golf-documents')
                    ->downloadable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Peserta')
                    ->alignment('center')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon')
                    ->alignment('center')
                    ->searchable(),
                Tables\Columns\TextColumn::make('play_time')->label('Waktu Main')
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->alignment('center')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_path')
                    ->label('Dokumen')
                    ->searchable()
                    ->alignment('center'),
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
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->icon('heroicon-o-pencil')
                    ->tooltip('Edit Peserta')
                    ->color('primary'),
                Tables\Actions\Action::make('preview')
                    ->label('')
                    ->tooltip('Lihat Dokumen')
                    ->color('info')
                    ->url(fn($record) => route('golf.preview', $record->uuid))
                    ->icon('heroicon-o-document')
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->document_path)), // tampil hanya jika ada file
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->icon('heroicon-o-trash')
                    ->tooltip('Hapus Peserta')
                    ->color('danger'),
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
            'index' => Pages\ListGolfParticipants::route('/'),
            'create' => Pages\CreateGolfParticipant::route('/create'),
            'edit' => Pages\EditGolfParticipant::route('/{record}/edit'),
        ];
    }
}
