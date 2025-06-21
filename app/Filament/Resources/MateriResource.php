<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MateriResource\Pages;
use App\Filament\Resources\MateriResource\RelationManagers;
use App\Models\Materi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MateriResource extends Resource
{
    protected static ?string $model = Materi::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $pluralLabel = 'Materi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Materi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal Materi')
                    ->required(),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi Materi')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Upload File')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240) // max 10MB
                    ->getUploadedFileNameForStorageUsing(function ($file, $livewire) {
                        $title = $livewire->data['title'] ?? 'file';
                        $slug = \Str::slug($title);
                        $extension = $file->getClientOriginalExtension();
                        return "{$slug}.{$extension}";
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul Materi')->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
                Tables\Columns\TextColumn::make('date')->label('Tanggal Materi')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMateris::route('/'),
            // 'create' => Pages\CreateMateri::route('/create'),
            // 'edit' => Pages\EditMateri::route('/{record}/edit'),
        ];
    }
}
