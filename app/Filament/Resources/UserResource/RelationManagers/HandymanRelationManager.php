<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class HandymanRelationManager extends RelationManager
{
    protected static string $relationship = 'handyman';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    // ->searchable()
                    ->required(),
                Select::make('subscription_type_id')
                    ->label('Subscription Plan')
                    ->relationship('subscriptionType', 'name'),
                Textarea::make('about'),
                // Textarea::make('tools'),
                TextInput::make('membership_level'),
                TextInput::make('reputation_score')
                    ->numeric(),
                TextInput::make('avg_rating')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(5),
                TextInput::make('experience'),
                TextInput::make('hire_count')
                    ->numeric(),
                Select::make('group_type')
                    ->options([
                        1 => 'Individual',
                        2 => 'Group',
                    ]),
                // Textarea::make('group_members'),
                // Textarea::make('certifications'),
                // Textarea::make('languages'),
                Select::make('approval_status')
                    ->options([
                        1 => 'Pending',
                        2 => 'Approved',
                        3 => 'Rejected',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('about')
            ->columns([
                TextColumn::make('subscriptionType.name')
                    ->sortable(),
                TextColumn::make('approval_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('membership_level'),
                TextColumn::make('reputation_score'),
                TextColumn::make('avg_rating'),
                TextColumn::make('experience'),
                TextColumn::make('hire_count'),
                TextColumn::make('group_type'),
                TextColumn::make('about')
                    ->words(5),
                TextColumn::make('tools')
                    ->words(5),
                TextColumn::make('group_members')
                    ->words(5),
                TextColumn::make('certifications')
                    ->words(5),
                TextColumn::make('languages')
                    ->words(5),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
