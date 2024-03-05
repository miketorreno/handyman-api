<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Handyman;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HandymanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HandymanResource\RelationManagers;

class HandymanResource extends Resource
{
    protected static ?string $model = Handyman::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subscriptionType.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('approval_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'warning',
                        '2' => 'success',
                        '3' => 'danger',
                    })
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListHandymen::route('/'),
            'create' => Pages\CreateHandyman::route('/create'),
            'edit' => Pages\EditHandyman::route('/{record}/edit'),
        ];
    }
}
