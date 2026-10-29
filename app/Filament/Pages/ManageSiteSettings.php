<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                ->label('Save All Settings')
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
                        ->label('Save All Settings')
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

        // Decode JSON arrays for repeaters
        if (isset($settings['about_milestones']) && is_string($settings['about_milestones'])) {
            $decoded = json_decode($settings['about_milestones'], true);
            if (is_array($decoded)) {
                $settings['about_milestones'] = $decoded;
            }
        }

        $this->form->fill($settings);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('White-Label Platform Configuration')
                    ->tabs([
                        // Tab 1: Branding & Theming
                        Tab::make('Branding & Theming')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                TextInput::make('ngo_name')
                                    ->label('NGO Legal / Brand Name')
                                    ->required()
                                    ->default('Hope Foundation'),
                                TextInput::make('ngo_tagline')
                                    ->label('Mission Tagline')
                                    ->default('For a Better Tomorrow'),
                                ColorPicker::make('primary_color')
                                    ->label('Primary Brand Color (--color-primary)')
                                    ->required()
                                    ->default('#16a34a'),
                                ColorPicker::make('primary_dark_color')
                                    ->label('Primary Dark / Hover Color (--color-primary-dark)')
                                    ->default('#15803d'),
                                ColorPicker::make('forest_bg_color')
                                    ->label('Hero Banner Dark Forest Background (--color-forest)')
                                    ->default('#041f13'),
                                ColorPicker::make('footer_bg_color')
                                    ->label('Footer Dark Background (--color-footer)')
                                    ->default('#071f12'),
                                ColorPicker::make('mint_bg_color')
                                    ->label('Soft Mint Card Tint (--color-mint-bg)')
                                    ->default('#eef8f1'),
                                ColorPicker::make('mint_border_color')
                                    ->label('Mint Card Border (--color-mint-border)')
                                    ->default('#d8f3df'),
                                ColorPicker::make('secondary_color')
                                    ->label('Headings & Dark Slate Text (--color-secondary)')
                                    ->required()
                                    ->default('#0f172a'),
                                ColorPicker::make('accent_color')
                                    ->label('Accent Green Badge / Script Color (--color-accent)')
                                    ->default('#4ade80'),
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
                            ])->columns(2),

                        // Tab 2: Page Hero Banners
                        Tab::make('Page Hero Banners')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('hero_banner_image')
                                    ->label('Homepage Hero Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image()
                                    ->helperText('Custom background photo for the flagship homepage banner.'),
                                FileUpload::make('about_banner_image')
                                    ->label('About Us Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image()
                                    ->helperText('Custom background photo for the About Us page header.'),
                                FileUpload::make('campaigns_banner_image')
                                    ->label('Campaigns Directory Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                                FileUpload::make('transparency_banner_image')
                                    ->label('Transparency Dashboard Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                                FileUpload::make('volunteer_banner_image')
                                    ->label('Volunteer Portal Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                                FileUpload::make('events_banner_image')
                                    ->label('Events Directory Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                                FileUpload::make('donate_banner_image')
                                    ->label('Donation Checkout Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                                FileUpload::make('status_banner_image')
                                    ->label('Donation Status Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                                FileUpload::make('contact_banner_image')
                                    ->label('Contact Us Banner Image')
                                    ->disk('public')
                                    ->directory('settings/banners')
                                    ->image(),
                            ])->columns(3),

                        // Tab 3: Homepage CMS
                        Tab::make('Homepage CMS')
                            ->icon('heroicon-o-home')
                            ->schema([
                                TextInput::make('hero_title')
                                    ->label('Homepage Hero Title')
                                    ->default('Direct Impact, Zero Deductions, 100% Transparency'),
                                Textarea::make('hero_subtitle')
                                    ->label('Homepage Hero Subtitle')
                                    ->rows(2)
                                    ->default('Hope Foundation works for education, health, clean water and a better future for underprivileged communities.'),
                                TextInput::make('hero_script_tag')
                                    ->label('Hero Script Accent Tag')
                                    ->default('Together'),
                                TextInput::make('hero_cta_text')
                                    ->label('Hero CTA Button Text')
                                    ->default('Donate Now'),
                                TextInput::make('home_video_url')
                                    ->label('Home Video Story Modal URL (YouTube)')
                                    ->placeholder('https://www.youtube.com/watch?v=...'),
                                TextInput::make('home_video_title')
                                    ->label('Home Video Title')
                                    ->default('See Our Work in Action'),
                                TextInput::make('stat_donations_text')
                                    ->label('Stat 1: Total Donations Override (leave blank for live database sum)')
                                    ->placeholder('e.g. ₹2,84,50,000'),
                                TextInput::make('stat_lives_text')
                                    ->label('Stat 2: Lives Impacted Override')
                                    ->default('12,500+'),
                                TextInput::make('stat_projects_text')
                                    ->label('Stat 3: Active Projects Override')
                                    ->default('25+'),
                                TextInput::make('stat_volunteers_text')
                                    ->label('Stat 4: Volunteers Count Override')
                                    ->default('500+'),
                            ])->columns(2),

                        // Tab 4: About Us CMS
                        Tab::make('About Us CMS')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                TextInput::make('about_hero_title')
                                    ->label('About Hero Title')
                                    ->default('About Us'),
                                TextInput::make('about_hero_subtitle')
                                    ->label('About Hero Subtitle')
                                    ->default('People | Purpose | Positive Change'),
                                TextInput::make('about_hero_script')
                                    ->label('About Hero Script Badge')
                                    ->default('Real People, Real Change 💚'),
                                TextInput::make('about_story_badge')
                                    ->label('Our Story Section Badge')
                                    ->default('OUR STORY • The Grassroots Story'),
                                TextInput::make('about_story_title')
                                    ->label('Our Story Headline')
                                    ->default('The Grassroots Story: A Small Step Towards a Brighter Tomorrow'),
                                Textarea::make('about_story_content')
                                    ->label('Our Story Narrative Paragraphs')
                                    ->rows(5)
                                    ->helperText('Tell the origin story, founders vision, and grassroots journey.'),
                                FileUpload::make('about_story_image')
                                    ->label('Our Story Center Feature Photo')
                                    ->disk('public')
                                    ->directory('settings/about')
                                    ->image(),
                                Textarea::make('about_mission')
                                    ->label('Our Mission Statement')
                                    ->rows(3),
                                Textarea::make('about_vision')
                                    ->label('Our Vision Statement')
                                    ->rows(3),
                                Textarea::make('about_values')
                                    ->label('Our Core Values Statement')
                                    ->rows(3),
                                Repeater::make('about_milestones')
                                    ->label('Journey Milestones Timeline')
                                    ->schema([
                                        TextInput::make('year')->label('Year')->required()->default('2025'),
                                        TextInput::make('line1')->label('Milestone Line 1')->required(),
                                        TextInput::make('line2')->label('Milestone Line 2')->required(),
                                    ])
                                    ->columns(3)
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ])->columns(2),

                        // Tab 5: Contact & Office
                        Tab::make('Contact & Office')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                                TextInput::make('contact_hero_title')
                                    ->label('Contact Hero Title')
                                    ->default('Contact Us'),
                                TextInput::make('contact_hero_subtitle')
                                    ->label('Contact Hero Subtitle')
                                    ->default('Have questions or want to partner with us? Reach out.'),
                                TextInput::make('contact_email')
                                    ->label('Official Contact Email')
                                    ->email()
                                    ->required()
                                    ->default('contact@hopefoundation.org'),
                                TextInput::make('contact_phone')
                                    ->label('Helpline Phone Number')
                                    ->required()
                                    ->default('+91 9876543210'),
                                Textarea::make('contact_address')
                                    ->label('Registered Office Address')
                                    ->rows(3)
                                    ->default('123 NGO Street, Varanasi, Uttar Pradesh - 221001'),
                                TextInput::make('office_city')
                                    ->label('Operational City')
                                    ->default('Varanasi, Uttar Pradesh'),
                                TextInput::make('contact_hours')
                                    ->label('Working / Operating Hours')
                                    ->default('Monday – Saturday: 9:00 AM – 6:00 PM'),
                                TextInput::make('contact_map_url')
                                    ->label('Google Map Embed URL')
                                    ->placeholder('https://www.google.com/maps/embed?...'),
                            ])->columns(2),

                        // Tab 6: Tax & 80G Compliance
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
                                TextInput::make('csr_reg_number')
                                    ->label('Ministry of Corporate Affairs CSR-1 Registration No'),
                                TextInput::make('fcra_status')
                                    ->label('FCRA Registration Status')
                                    ->default('Applied / Eligible for Domestic Donations'),
                                TextInput::make('receipt_prefix')
                                    ->label('Donation Receipt Prefix')
                                    ->default('HF')
                                    ->required(),
                                TextInput::make('volunteer_prefix')
                                    ->label('Volunteer ID Prefix')
                                    ->default('HF-VOL')
                                    ->required(),
                                TextInput::make('authorized_sign_name')
                                    ->label('Authorized Signatory Name & Title'),
                                FileUpload::make('authorized_sign_image')
                                    ->label('Digital Stamp / Signature Image')
                                    ->disk('public')
                                    ->directory('settings')
                                    ->image()
                                    ->maxSize(2048),
                            ])->columns(2),

                        // Tab 7: Social Links
                        Tab::make('Social & Links')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
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
                                TextInput::make('linkedin_url')
                                    ->label('LinkedIn Organization URL')
                                    ->url(),
                                TextInput::make('whatsapp_number')
                                    ->label('WhatsApp Support Number')
                                    ->placeholder('+919876543210'),
                            ])->columns(2),

                        // Tab 8: Legal Policies
                        Tab::make('Policies & Legal Text')
                            ->icon('heroicon-o-scale')
                            ->schema([
                                Textarea::make('privacy_policy_content')
                                    ->label('Privacy Policy Custom Text')
                                    ->rows(6)
                                    ->helperText('Leave empty to use standardized default compliance text.'),
                                Textarea::make('terms_conditions_content')
                                    ->label('Terms and Conditions Custom Text')
                                    ->rows(6)
                                    ->helperText('Leave empty to use standardized default compliance text.'),
                                Textarea::make('disclaimer_content')
                                    ->label('Official Disclaimer Text')
                                    ->rows(4)
                                    ->helperText('Leave empty to use standardized default compliance text.'),
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
            'primary_dark_color' => 'branding',
            'forest_bg_color' => 'branding',
            'footer_bg_color' => 'branding',
            'mint_bg_color' => 'branding',
            'mint_border_color' => 'branding',
            'secondary_color' => 'branding',
            'accent_color' => 'branding',
            'logo_path' => 'branding',
            'favicon_path' => 'branding',

            'hero_banner_image' => 'banners',
            'about_banner_image' => 'banners',
            'campaigns_banner_image' => 'banners',
            'transparency_banner_image' => 'banners',
            'volunteer_banner_image' => 'banners',
            'events_banner_image' => 'banners',
            'donate_banner_image' => 'banners',
            'status_banner_image' => 'banners',
            'contact_banner_image' => 'banners',

            'hero_title' => 'hero_cms',
            'hero_subtitle' => 'hero_cms',
            'hero_script_tag' => 'hero_cms',
            'hero_cta_text' => 'hero_cms',
            'home_video_url' => 'hero_cms',
            'home_video_title' => 'hero_cms',
            'stat_donations_text' => 'hero_cms',
            'stat_lives_text' => 'hero_cms',
            'stat_projects_text' => 'hero_cms',
            'stat_volunteers_text' => 'hero_cms',

            'about_hero_title' => 'about_cms',
            'about_hero_subtitle' => 'about_cms',
            'about_hero_script' => 'about_cms',
            'about_story_badge' => 'about_cms',
            'about_story_title' => 'about_cms',
            'about_story_content' => 'about_cms',
            'about_story_image' => 'about_cms',
            'about_mission' => 'about_cms',
            'about_vision' => 'about_cms',
            'about_values' => 'about_cms',
            'about_milestones' => 'about_cms',

            'contact_hero_title' => 'contact',
            'contact_hero_subtitle' => 'contact',
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'contact_address' => 'contact',
            'office_city' => 'contact',
            'contact_hours' => 'contact',
            'contact_map_url' => 'contact',

            'ngo_pan_number' => 'receipt_legal',
            'ngo_reg_number' => 'receipt_legal',
            'ngo_darpan_id' => 'receipt_legal',
            'has_80g' => 'receipt_legal',
            '80g_reg_number' => 'receipt_legal',
            '12a_reg_number' => 'receipt_legal',
            'csr_reg_number' => 'receipt_legal',
            'fcra_status' => 'receipt_legal',
            'receipt_prefix' => 'receipt_legal',
            'volunteer_prefix' => 'receipt_legal',
            'authorized_sign_name' => 'receipt_legal',
            'authorized_sign_image' => 'receipt_legal',

            'facebook_url' => 'social',
            'twitter_url' => 'social',
            'instagram_url' => 'social',
            'youtube_url' => 'social',
            'linkedin_url' => 'social',
            'whatsapp_number' => 'social',

            'privacy_policy_content' => 'legal_cms',
            'terms_conditions_content' => 'legal_cms',
            'disclaimer_content' => 'legal_cms',
        ];

        foreach ($state as $key => $value) {
            $group = $groupMapping[$key] ?? 'general';

            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            } elseif (is_array($value)) {
                $value = json_encode($value);
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'group' => $group]
            );
        }

        Notification::make()
            ->title('White-label platform settings updated successfully')
            ->success()
            ->send();
    }
}
