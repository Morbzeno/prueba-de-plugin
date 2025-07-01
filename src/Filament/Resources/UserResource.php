<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Morbzeno\PruebaDePlugin\Filament\Resources\UserResource\Pages;
use Morbzeno\PruebaDePlugin\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Usuarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->string()
                    ->maxLength(100)
                    ->minLength(5)
                    ->required()
                    ->label('Nombre'),

                TextInput::make('email')
                    ->email()
                    ->maxLength(100)
                    ->minLength(10)
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord)
                    ->label('Email'),

                TextInput::make('password')
                    ->helperText('La contraseña debe contener por lo menos una letra mayuscula, una letra minuscula, un caracter especial y minimo 8 caraceteres para ser valida')
                    ->rule('regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/')
                    ->required()
                    ->label('Contraseña')
                    ->password()
                    ->maxLength(50)
                    ->minLength(4)
                    ->autocomplete(false)
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),

                Select::make('roles')->relationship(
                    name: 'roles',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->where('name', '!=', 'super_admin')
                )->required()->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'super_admin');
                })
            )
            ->columns([

                TextColumn::make('name'),
                TextColumn::make('email'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function navigation(): NavigationItem
    {
        return parent::navigation()
            ->visible(auth()->user()?->can('ver_usuario'));
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('ver_cualquier_usuario');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('actualizar_usuario', $record);
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('eliminar_cualquier_usuario');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('crear_usuario');
    }
}
