<?php

namespace Morbzeno\PruebaDePlugin\Filament\Resources;

use Filament\Forms\Components\MultiSelect;
use Morbzeno\PruebaDePlugin\Filament\Resources\BlogsResource\Pages;
use App\Filament\Resources\BlogsResource\RelationManagers;
use Morbzeno\PruebaDePlugin\Models\Blogs;
use Morbzeno\PruebaDePlugin\Models\Tag;
use Illuminate\Support\Facades\Gate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogsResource extends Resource
{
    protected static ?string $model = Blogs::class;
    protected static ?string $modelLabel = 'Blogs';
    protected static ?string $NavigationLabel = 'Blogs';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Publicaciones';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                ->required()
                ->maxLength(50)
                ->minLength(5)
                ->label('Titulo'),

                Select::make('author')
                ->label('Autor')
                ->relationship(
                    name: 'users',
                    titleAttribute: 'name',
                )
                ->required()
                ->preload()
                ->native(false),

                Textarea::make('description')
                ->required()
                ->label('Descripcion')
                ->rows(2)
                ->minLength(2)
                ->maxLength(1000)
                ->columnSpan([
                    'sm' => 2,
                ]),
                FileUpload::make("image")
                ->image()
                ->disk(config('filament-blog.image.disk', 'public'))
                ->visibility(config('filament-blog.image.visibility', 'public'))
                ->directory(config('filament-blog.avatar.directory', 'blog'))
                ->columnSpan([
                    'sm' => 2,
                ]),

                Select::make('category_id')
                ->label('Categoría')
                ->relationship(
                    name: 'category',
                    titleAttribute: 'name',
                )
                ->required()
                ->native(false)
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                    ->required(),
                    Forms\Components\TextInput::make('description')
                ]),
            
            // Select::make('tags')
            //     ->label('Etiquetas')
            //     ->multiple()
            //     ->relationship(
            //         name: 'tags',
            //         titleAttribute: 'name',
            //     )
            //     ->required()
            //     ->preload()
            //     ->native(false)
            //     ->createOptionForm([
            //         Forms\Components\TextInput::make('name')
            //         ->required(),
            //         Forms\Components\TextInput::make('description')
            //     ]),
            
            MultiSelect::make('tags')
            ->label('Etiquetas')
            ->relationship('tags', 'name') // <- relación Eloquent
            ->searchable()
            ->preload()
            ->createOptionUsing(function (string $value) {
                $tag = Tag::create(['name' => $value]);
                return $tag->getKey(); // Retorna el ID como clave
            })
            ->required(),


            TextInput::make('slug')
            ->label('slug')
            ->visible(fn (String $operation) => $operation === 'edit')
            ->unique(ignoreRecord:true)
        ]);
                
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                ->disk(config('filament-blog.image.disk', 'public'))
                ->visibility(config('filament-blog.image.visibility', 'public'))
                ->label(__('Imagen'))
                ->circular(),
                TextColumn::make('title')
                ->label('Titulo'),
                TextColumn::make('users.name')
                ->label('Autor')
                


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('verBlog')
                    ->label('Ver en pagina')
                    ->url(fn ($record) => url('/blog/' . $record->slug))
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlogs::route('/create'),
            'edit' => Pages\EditBlogs::route('/{record}/edit'),
        ];
    }

    public static function navigation(): NavigationItem
    {
    return parent::navigation()
        ->visible(auth()->user()?->can('ver_publicacion'));
    }
    public static function canViewAny(): bool
    {
        return Gate::allows('ver_cualquier_publicacion');
    }
    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('actualizar_publicacion', $record);
    }
    
    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('eliminar_cualquier_publicacion');
    }
    
    public static function canCreate(): bool
    {
        return auth()->user()->can('crear_publicacion');
    }

    protected static function syncTags(Form $form, Model $post): void
{
    $tagNames = collect($form->getState()['tags'])
        ->map(fn($tag) => trim($tag))
        ->filter()
        ->unique();

    $tagIds = [];

    foreach ($tagNames as $name) {
        $tag = \App\Models\Tag::firstOrCreate([
            'name' => $name,
        ], [
            'slug' => \Str::slug($name),
        ]);

        $tagIds[] = $tag->id;
    }

    $post->tags()->sync($tagIds);
}

}
