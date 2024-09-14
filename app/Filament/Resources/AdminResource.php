<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Filament\Resources\AdminResource\RelationManagers;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\AdminResource\Pages\CreateAdmin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Please enter a name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->placeholder('Please enter a email')
                    ->required(),
                TextInput::make('password')
                    ->placeholder('Please enter admin password')
                    ->dehydrated(fn($state) => !empty($state))
                    ->password()
                    ->revealable()
                    ->confirmed()
                    ->required(fn($livewire) => $livewire instanceof CreateAdmin),
                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->placeholder('Please enter a confirm password')
                    ->password()
                    ->dehydrated(false)
                    ->revealable()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateAdmin),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->deferLoading()
            ->striped()
            ->paginated([10, 20, 30, 50, 100, 'all'])
        ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->badge()
                    ->copyable()
                    ->copyMessage('Copied')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListAdmins::route('/'),
//            'create' => Pages\CreateAdmin::route('/create'),
//            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
