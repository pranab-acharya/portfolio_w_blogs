<?php

namespace App\Filament\Resources\Abouts;

use App\Filament\Resources\Abouts\Pages\CreateAbout;
use App\Filament\Resources\Abouts\Pages\EditAbout;
use App\Filament\Resources\Abouts\Pages\ListAbouts;
use App\Filament\Resources\Abouts\Pages\ViewAbout;
use App\Filament\Resources\Abouts\Schemas\AboutForm;
use App\Filament\Resources\Abouts\Schemas\AboutInfolist;
use App\Filament\Resources\Abouts\Tables\AboutsTable;
use App\Models\About;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::InformationCircle;

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'About';

    protected static ?string $modelLabel = 'About';

    public static function form(Schema $schema): Schema
    {
        return AboutForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AboutInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AboutsTable::configure($table);
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
            'index' => ListAbouts::route('/'),
            'create' => CreateAbout::route('/create'),
            'view' => ViewAbout::route('/{record}'),
            'edit' => EditAbout::route('/{record}/edit'),
        ];
    }
}
