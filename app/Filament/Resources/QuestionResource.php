<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $pluralLabel = 'Pertanyaan';
    protected static ?string $slug = 'questions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('level')
                    ->label('Level')
                    ->options([
                        '1' => 'Level 1',
                        '2' => 'Level 2',
                        '3' => 'Level 3',
                        '4' => 'Level 4',
                    ])
                    ->required(),

                Forms\Components\Toggle::make('is_pretest')
                    ->label('Pretest')
                    ->helperText('Tandai jika pertanyaan ini untuk pretest')
                    ->default(false),

                Forms\Components\Toggle::make('is_posttest')
                    ->label('Posttest')
                    ->helperText('Tandai jika pertanyaan ini untuk posttest')
                    ->default(false),

                Forms\Components\TextInput::make('points')
                    ->label('Point')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),

                Forms\Components\Textarea::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->columnSpanFull()
                    ->rows(3),

                Forms\Components\Repeater::make('answers')
                    ->relationship() // automatically uses 'answers' relation
                    ->label('Jawaban')
                    ->minItems(2)
                    ->maxItems(4)
                    ->schema([
                        Forms\Components\TextInput::make('answer')
                            ->label('Jawaban')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_correct')
                            ->label('Benar?')
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->required()
                    ->helperText('Isi 2-4 jawaban, tandai mana yang benar.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')->limit(60)->searchable(),
                Tables\Columns\TextColumn::make('points'),
                Tables\Columns\TextColumn::make('level')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '2' => 'primary',
                        '3' => 'warning',
                        '4' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
