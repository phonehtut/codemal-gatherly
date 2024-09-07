<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormDataResource\Pages;
use App\Filament\Resources\FormDataResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormDataResource extends Resource
{
    protected static ?string $model = \App\Models\Form::class;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = "Events Management";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('event.id')
                    ->label('Event ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied'),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied'),
                TextColumn::make('dob')
                    ->label('Date Of Birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('event.users.name')
                    ->label('Organizer')
                    ->default('Unknown')
                    ->badge()
                    ->colors([
                        'success' => fn ($state) => $state !== 'Unknown',  // Apply 'success' color when organizer is known
                        'danger' => fn ($state) => $state === 'Unknown',   // Apply 'danger' color when organizer is unknown
                    ]),

            ])
            ->filters([
                SelectFilter::make('event')
                    ->relationship('event', 'id')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('name')
                    ->label('Register By')
                    ->options(
                        \App\Models\Form::query()->pluck('name', 'name')->toArray() // Assuming Form is in the App\Models namespace
                    )
                    ->searchable()
                    ->preload()
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name'),
                        TextEntry::make('email')
                            ->label('Email')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                        TextEntry::make('phone')
                            ->label('Phone')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                        TextEntry::make('dob')
                            ->label('Date Of Birth')
                            ->default('Unknown'),
                    ])
                ->columns(4),
                Section::make('Event Information')
                    ->schema([
                        ImageEntry::make('event.image')
                            ->label('Image')
                            ->columnSpan(4)
                            ->alignCenter()
                            ->hiddenLabel()
                            ->disk('public'),
                        TextEntry::make('event.title')
                            ->label('Event Title'),
                        TextEntry::make('event.start_date')
                            ->label('Start Date')
                            ->date(),
                        TextEntry::make('event.end_date')
                            ->label('End Date')
                            ->date(),
                        TextEntry::make('event.limit')
                            ->label('Limit')
                            ->badge()
                            ->formatStateUsing(function ($state) {
                                return $state == 0 ? 'Unlimited' : (int) $state;
                            }),
                        TextEntry::make('event.category.name')
                            ->label('Category')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                        TextEntry::make('event.status')
                            ->label('Status')
                            ->formatStateUsing(function ($state) {
                                return $state ? 'Active' : 'Inactive';
                            })
                            ->colors([
                                'success' => fn ($state) => $state,
                                'danger' => fn ($state) => !$state,
                            ]),
                        TextEntry::make('event.plaform')
                            ->label('Platform'),
                        TextEntry::make('location')
                            ->label('Location'),
                        TextEntry::make('event.description')
                            ->label('Event Description')
                            ->columnSpan('full'),
                    ])
                ->columns(4),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormData::route('/'),
            'create' => Pages\CreateFormData::route('/create'),
            'view' => Pages\ViewFormData::route('/{record}/detail'),
            'edit' => Pages\EditFormData::route('/{record}/edit'),
        ];
    }
}
