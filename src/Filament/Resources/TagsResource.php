<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Morbzeno\PruebaDePlugin\Filament\Resources\TagsResource\Pages;
use Morbzeno\PruebaDePlugin\Models\Tag;

class TagsResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $modelLabel = 'etiqueta';

    protected static ?string $NavigationLabel = 'Etiquetas';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Publicaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->minLength(4)
                    ->label('Nombre'),

                TextInput::make('description')
                    ->required()
                    ->maxLength(500)
                    ->minLength(5)
                    ->label('Descripción'),

                TextInput::make('slug')
                ->label('slug')
                ->visible(fn (String $operation) => $operation === 'edit')
                ->unique(ignoreRecord:true )
            
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Etiqueta'),

                TextColumn::make('slug')
                    ->label('Slug'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('verBlog')
                    ->label('Ver en pagina')
                    ->url(fn ($record) => url('/tag/' . $record->slug))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTags::route('/create'),
            'edit' => Pages\EditTags::route('/{record}/edit'),
        ];
    }

    public static function navigation(): NavigationItem
    {
        return parent::navigation()
            ->visible(auth()->user()?->can('ver_etiqueta'));
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('ver_cualquier_etiqueta');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('actualizar_etiqueta', $record);
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('eliminar_cualquier_etiqueta');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('crear_etiqueta');
    }
}
