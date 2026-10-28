<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AdminWelcome extends Widget
{
    protected string $view = 'filament.widgets.admin-welcome';
    protected int|string|array $columnSpan = 'full';
}
