<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UserAnswer;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserAnswerResource\Pages;
use App\Filament\Resources\UserAnswerResource\RelationManagers;

class UserAnswerResource extends Resource
{
    protected static ?string $model = UserAnswer::class;
    protected static ?string $pluralLabel = 'Riwayat Kuis';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('quiz_id')
                    ->relationship('quiz', 'id')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'question')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('answer_id')
                    ->relationship('answer', 'answer')
                    ->searchable()
                    ->nullable(),

                Forms\Components\Toggle::make('is_correct')
                    ->label('Correct?'),

                Forms\Components\DateTimePicker::make('answered_at')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('quiz.id')->label('Quiz ID')->sortable(),
                Tables\Columns\TextColumn::make('question.question')->label('Question')->limit(40),
                Tables\Columns\TextColumn::make('answer.answer')->label('Answer')->limit(20),
                Tables\Columns\IconColumn::make('is_correct')->boolean()->label('Correct'),
                Tables\Columns\TextColumn::make('answered_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
                    ->after(function (UserAnswer $record) {
                        self::recalculateLeaderboard($record->user_id);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function (Builder $query) {
                            $query->get()->groupBy('user_id')->each(function ($answers, $userId) {
                                self::recalculateLeaderboard($userId);
                            });
                        }),
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
            'index' => Pages\ListUserAnswers::route('/'),
            'create' => Pages\CreateUserAnswer::route('/create'),
            'edit' => Pages\EditUserAnswer::route('/{record}/edit'),
        ];
    }

    protected static function recalculateLeaderboard($userId)
    {
        // Sum all correct answers' point from UserAnswer
        $score = UserAnswer::where('user_id', $userId)
            ->where('is_correct', true)
            ->with('question')
            ->get()
            ->sum(function ($answer) {
                return $answer->question?->points ?? 0;
            });

        // Update or create leaderboard entry
        \App\Models\Leaderboard::updateOrCreate(
            ['user_id' => $userId],
            ['score' => $score]
        );
    }
}
