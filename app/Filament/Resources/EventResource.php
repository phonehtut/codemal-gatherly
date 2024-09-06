<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\GlobalSearch\Actions\Action;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'org_name', 'category.name'];
    }

    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('edit')
                ->url(static::getUrl('edit', ['record' => $record])),
            Action::make('view')
                ->url(static::getUrl('view', ['record' => $record])),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) Event::count();
    }

    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->placeholder('Upload Image')
                    ->required()
                    ->disk('public')
                    ->directory('events/images'),
                Forms\Components\FileUpload::make('org_logo')
                    ->label('Organization Logo')
                    ->placeholder('Upload Organization Logo')
                    ->required()
                    ->disk('public')
                    ->directory('events/org_logos'),
                TextInput::make('title')
                    ->label('Title')
                    ->placeholder('Please enter event title')
                    ->required(),
                TextInput::make('org_name')
                    ->label('Organization Name')
                    ->placeholder('Please enter event organization name')
                    ->required(),
                TextInput::make('org_email')
                    ->label('Organization Email')
                    ->placeholder('Please enter event organization email')
                    ->required(),
                TextInput::make('org_phone')
                    ->label('Organization Phone')
                    ->placeholder('Please enter event organization phone')
                    ->required(),
                Forms\Components\MarkdownEditor::make('description')
                    ->label('Description')
                    ->placeholder('Please enter event description'),
                Forms\Components\MarkdownEditor::make('location')
                    ->label('Location')
                    ->placeholder('Please enter event description'),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->placeholder('Please enter event start date')
                    ->required()
                    ->native(false),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->placeholder('Please enter event end date')
                    ->native(false)
                    ->required(),
                TextInput::make('limit')
                    ->label('Limit')
                    ->placeholder('Please enter event limit')
                    ->helperText('No Fill is Unlimited register form'),
                Forms\Components\Select::make('plaform')
                    ->label('Platform')
                    ->placeholder('Please select event platform')
                    ->options([
                        'Online' => 'Online',
                        'Offline' => 'Offline',
                        'Hybrid' => 'Hybrid',
                    ])
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Category')
                    ->placeholder('Please select event category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        '0' => 'Inactive',
                        '1' => 'Active',
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->striped()
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public'),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                TextColumn::make('org_name')
                    ->label('Organization Name')
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied')
                    ->color("info")
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('org_email')
                    ->label('Organization Email')
                    ->searchable()
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->copyMessage('Copied')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('org_phone')
                    ->label('Organization Phone')
                    ->searchable()
                    ->badge()
                    ->color('warning')
                    ->copyable()
                    ->copyMessage('Copied')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('limit')
                    ->label('Limit')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return $state == 0 ? 'Unlimited' : (int) $state;
                    })
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->searchable()
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('plaform')
                    ->label('Platform')
                    ->searchable(),
//                TextColumn::make('status')
//                    ->label('Status')
//                    ->formatStateUsing(function ($state) {
//                        return $state ? 'Active' : 'Inactive';
//                    })
//                    ->colors([
//                        'success' => fn ($state) => $state,
//                        'danger' => fn ($state) => !$state,
//                    ]),
                ToggleColumn::make('status')
                    ->label('Status')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
                Section::make('Event Information')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Image')
                            ->columnSpan(4)
                            ->alignCenter()
                            ->hiddenLabel()
                            ->disk('public'),
                        TextEntry::make('title')
                            ->label('Event Title'),
                        TextEntry::make('start_date')
                            ->label('Start Date')
                            ->date(),
                        TextEntry::make('end_date')
                            ->label('End Date')
                            ->date(),
                        TextEntry::make('limit')
                            ->label('Limit')
                            ->badge()
                            ->formatStateUsing(function ($state) {
                                return $state == 0 ? 'Unlimited' : (int) $state;
                            }),
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(function ($state) {
                                return $state ? 'Active' : 'Inactive';
                            })
                           ->colors([
                                'success' => fn ($state) => $state,
                                'danger' => fn ($state) => !$state,
                            ]),
                        TextEntry::make('plaform')
                            ->label('Platform'),
                        TextEntry::make('location')
                            ->label('Location'),
                        TextEntry::make('description')
                            ->label('Event Description')
                            ->columnSpan('full'),
                    ])
                    ->columns(4),
                Section::make('Organization Information')
                    ->schema([
                        ImageEntry::make('org_logo')
                            ->label('Organization Logo')
                            ->columnSpan('full')
                            ->alignCenter()
                            ->hiddenLabel()
                            ->disk('public'),
                        TextEntry::make('org_name')
                            ->label('Organization Name')
                            ->badge(),
                        TextEntry::make('org_email')
                            ->label('Organization Email')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                        TextEntry::make('org_phone')
                            ->label('Organization Phone')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                        TextEntry::make('users.name')
                            ->label('Organizer')
                            ->badge()
                            ->copyable()
                            ->copyMessage('Copied'),
                    ])
                    ->columns(4),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}/view'),
        ];
    }
}
