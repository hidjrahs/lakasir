<?php

namespace App\Filament\Tenant\Resources\SellingResource\Pages;

use App\Features\PrintSellingA5;
use App\Filament\Tenant\Resources\SellingResource;
use App\Models\Tenants\About;
use App\Models\Tenants\Selling;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class ViewSelling extends ViewRecord
{
    protected static string $resource = SellingResource::class;

    public ?About $about = null;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->about = About::first();
    }

    public function getTitle(): string|Htmlable
    {
        return 'View '.$this->getRecord()->code;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make(__('Print A5'))
                ->icon('heroicon-s-printer')
                ->extraAttributes([
                    'id' => 'printA5button',
                ])
                ->color(Color::Teal)
                ->visible(can('can print selling') && feature(PrintSellingA5::class)),
            Action::make('print')
                ->icon('heroicon-s-printer')
                ->extraAttributes([
                    'id' => 'usbButton',
                ])
                ->visible(can('can print selling')),
        ];
    }

    public function getView(): string
    {
        return 'filament.tenant.resources.sellings.pages.view-selling';
    }

    public function getRecord(): Selling
    {
        return $this->record->load('sellingDetails.product');
    }
}
