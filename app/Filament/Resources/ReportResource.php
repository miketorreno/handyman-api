<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Report;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReportResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReportResource\RelationManagers;

class ReportResource extends Resource
{
    // protected static ?string $make = '';
    // protected static ?string $label = '';
    // protected static ?string $options = '';

    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function canCreate(): bool
    {
       return false;
    }

    public static function form(Form $form): Form
    {
        // $make = '';
        // $label = '';
        // $options = '';

        // if ('reportable_type' == 'App\Models\Handyman') {
        //     $make = 'handyman_id';
        //     $label = 'Reported Handyman';
        //     $options = Handyman::with('user')->where('id', 'reportable_id')->pluck('name', 'id');
        // } else if ('reportable_type' == 'App\Models\User') {
        //     $make = 'handyman_id';
        //     $label = 'Reported User';
        //     $options = User::where('id', 'reportable_id')->pluck('name', 'id');
        // }

        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Reporter')
                    ->relationship('user', 'name')
                    // ->searchable()
                    ->required()
                    ->disabled(),
                TextInput::make('reportable_id')
                    ->disabled(),
                TextInput::make('reportable_type')
                    ->disabled(),
                // if ('reportable_type' = 'App\Models\Handyman') {
                //     Select::make('reportable_id')
                //         ->label('Reported Handyman')
                //         ->options(Handyman::with('user')->where('id', 'reportable_id')->pluck('name', 'id'))
                //         // ->relationship('handyman', 'name')
                //         ->required(),
                // } else {
                //     Select::make('reportable_id')
                //         ->label('Reported User')
                //         ->options(User::where('id', 'reportable_id')->pluck('name', 'id'))
                //         // ->relationship('user', 'name')
                //         ->required(),
                // }
                Select::make('report_status')
                    ->disabled()
                    ->options([
                        1 => 'Reviewed',
                        2 => 'Not reviewed',
                    ]),
                Textarea::make('reason')
                    ->disabled()
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reason')
                    ->words(5)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('report_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '2' => 'warning',
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListReports::route('/'),
            // 'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
