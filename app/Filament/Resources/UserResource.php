<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->placeholder('Avatar')
                    ->hiddenLabel()
                    ->alignCenter()
                    ->avatar()
                    ->disk('public')
                    ->directory('users/avatars')
                    ->columnSpan('full'),
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Please enter name')
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('email')
                    ->label('Email')
                    ->placeholder('Please enter email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),
                TextInput::make('phone')
                    ->label('Phone')
                    ->placeholder('Please enter phone')
                    ->required()
                    ->tel()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->placeholder('Please enter admin password')
                    ->dehydrated(fn($state) => !empty($state))
                    ->password()
                    ->revealable()
                    ->confirmed()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser),
                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->placeholder('Please enter a confirm password')
                    ->password()
                    ->dehydrated(false)
                    ->revealable()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser),
                Forms\Components\Toggle::make('status')
                    ->label('Status')
                    ->default(true)
                    ->inline()
                    ->onColor('success')
                    ->offColor('danger')
            ]);
    }

//'name',
//'email',
//'phone',
//'avatar',
//'password',
//'status'

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable()
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->onColor('success')
                    ->offColor('danger')
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
