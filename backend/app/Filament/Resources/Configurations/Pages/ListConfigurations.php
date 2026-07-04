<?php

namespace App\Filament\Resources\Configurations\Pages;

use App\Filament\Resources\Configurations\ConfigurationResource;
use Filament\Resources\Pages\ListRecords;

class ListConfigurations extends ListRecords
{
    protected static string $resource = ConfigurationResource::class;
}
