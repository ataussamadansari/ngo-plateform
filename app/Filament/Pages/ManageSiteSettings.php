<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'White-Label Settings';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings & System';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'settings';

    protected static ?string $title = 'White-Label Platform Settings';

    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Save Settings')
                        ->submit('save')
                        ->size('lg')
                        ->color('primary')
                        ->icon('heroicon-o-check')
                        ->keyBindings(['mod+s']),
                ])->alignment(Alignment::End),
            ]);
    }

    public function mount(): void
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        // Cast boolean settings properly
        if (isset($settings['has_80g'])) {
            $settings['has_80g'] = (bool) $settings['has_80g'];
        }

        $this->form->fill($settings);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('White-Label Settings')
                    ->tabs([
                        Tab::make('Branding & Theming')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                TextInput::make('ngo_name')
                                    ->label('NGO Legal / Brand Name')
                                    ->required(),
                                TextInput::make('ngo_tagline')
                                    ->label('Mission Tagline'),
                                ColorPicker::make('primary_color')
                                    ->label('Primary Theme Color (--color-primary)')
                                    ->required()
                                    ->default('#16a34a'),
                                ColorPicker::make('secondary_color')
                                    ->label('Secondary Theme Color (--color-secondary)')
                                    ->required()
                                    ->default('#0f172a'),
                                FileUpload::make('logo_path')
                                    ->label('NGO Brand Logo')
                                    ->disk('public')
                                    ->directory('settings')
                                    ->image()
                                    ->maxSize(2048),
                                FileUpload::make('favicon_path')
                                    ->label('Browser Favicon')
                                    ->disk('public')
                                    ->directory('settings')
                                    ->maxSize(1024),
                            ]),
                        Tab::make('Tax & 80G Compliance')
                            ->icon('heroicon-o-document-check')
                            ->schema([
                                TextInput::make('ngo_pan_number')
                                    ->label('NGO PAN Number')
                                    ->required(),
                                TextInput::make('ngo_reg_number')
                                    ->label('Society / Trust Registration Number'),
                                TextInput::make('ngo_darpan_id')
                                    ->label('NITI Aayog NGO Darpan ID'),
                                Toggle::make('has_80g')
                                    ->label('80G Tax Exemption Eligible')
                                    ->default(true),
                                TextInput::make('80g_reg_number')
                                    ->label('80G Order / Registration Number'),
                                TextInput::make('12a_reg_number')
                                    ->label('12A Order / Registration Number'),
                                TextInput::make('receipt_prefix')
                                    ->label('Donation Receipt Prefix')
                                    ->default('KSF')
                                    ->required(),
                                TextInput::make('volunteer_prefix')
                                    ->label('Volunteer ID Prefix')
                                    ->default('KSF-VOL')
                                    ->required(),
                                TextInput::make('authorized_sign_name')
                                    ->label('Authorized Signatory Name & Title'),
                                FileUpload::make('authorized_sign_image')
                                    ->label('Digital Stamp / Signature Image')
                                    ->disk('public')
                                    ->directory('settings')
                                    ->image()
                                    ->maxSize(2048),
                            ]),
                        Tab::make('Contact & Office')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                                TextInput::make('contact_email')
                                    ->label('Official Contact Email')
                                    ->email()
                                    ->required(),
                                TextInput::make('contact_phone')
                                    ->label('Helpline Phone Number')
                                    ->required(),
                                Textarea::make('contact_address')
                                    ->label('Registered Office Address')
                                    ->rows(3),
                                TextInput::make('office_city')
                                    ->label('Operational City'),
                            ]),
                        Tab::make('Hero & Social Links')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                TextInput::make('hero_title')
                                    ->label('Homepage Hero Title'),
                                Textarea::make('hero_subtitle')
                                    ->label('Homepage Hero Subtitle')
                                    ->rows(2),
                                TextInput::make('hero_cta_text')
                                    ->label('Hero CTA Button Text')
                                    ->default('Donate Now'),
                                TextInput::make('facebook_url')
                                    ->label('Facebook Page URL')
                                    ->url(),
                                TextInput::make('twitter_url')
                                    ->label('Twitter / X URL')
                                    ->url(),
                                TextInput::make('instagram_url')
                                    ->label('Instagram Profile URL')
                                    ->url(),
                                TextInput::make('youtube_url')
                                    ->label('YouTube Channel URL')
                                    ->url(),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $groupMapping = [
            'ngo_name' => 'branding',
            'ngo_tagline' => 'branding',
            'primary_color' => 'branding',
            'secondary_color' => 'branding',
            'logo_path' => 'branding',
            'favicon_path' => 'branding',
            'ngo_pan_number' => 'receipt_legal',
            'ngo_reg_number' => 'receipt_legal',
            'ngo_darpan_id' => 'receipt_legal',
            'has_80g' => 'receipt_legal',
            '80g_reg_number' => 'receipt_legal',
            '12a_reg_number' => 'receipt_legal',
            'receipt_prefix' => 'receipt_legal',
            'volunteer_prefix' => 'receipt_legal',
            'authorized_sign_name' => 'receipt_legal',
            'authorized_sign_image' => 'receipt_legal',
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'contact_address' => 'contact',
            'office_city' => 'contact',
            'hero_title' => 'hero_cms',
            'hero_subtitle' => 'hero_cms',
            'hero_cta_text' => 'hero_cms',
            'facebook_url' => 'social',
            'twitter_url' => 'social',
            'instagram_url' => 'social',
            'youtube_url' => 'social',
        ];

        foreach ($state as $key => $value) {
            $group = $groupMapping[$key] ?? 'general';

            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'group' => $group]
            );
        }

        Notification::make()
            ->title('White-label settings saved successfully')
            ->success()
            ->send();
    }
}
