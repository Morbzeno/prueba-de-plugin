<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources;

use Morbzeno\PruebaDePlugin\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use Morbzeno\PruebaDePlugin\Models\Category;
use Illuminate\Support\Facades\Gate;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $modelLabel = 'categoria';
    protected static ?string $NavigationLabel = 'Categorias';
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
                ->label('Descripcion'),

                TextInput::make('slug')
                ->label('slug')
                ->visible(fn (String $operation) => $operation === 'edit'),
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
                    ->url(fn ($record) => url('/category/' . $record->slug))
                    ->openUrlInNewTab()
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    public static function navigation(): NavigationItem
    {
    return parent::navigation()
        ->visible(auth()->user()?->can('ver_categoría'));
    }
    
    public static function canViewAny(): bool
    {
        return Gate::allows('ver_cualquier_categoría');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('actualizar_categoría', $record);
    }
    
    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('eliminar_cualquier_categoría');
    }
    
    public static function canCreate(): bool
    {
        return auth()->user()->can('crear_categoría');
    }
}
