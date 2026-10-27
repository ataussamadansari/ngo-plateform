<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Campaign Manager')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('General & Schedule')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Campaign Title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                        if ($operation === 'create') {
                                            $set('slug', Str::slug($state ?? ''));
                                        }
                                    }),
                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Cause Category'),
                                TextInput::make('goal_amount')
                                    ->label('Funding Target Goal')
                                    ->numeric()
                                    ->prefix('₹')
                                    ->minValue(1)
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'draft' => 'Draft (Hidden)',
                                        'active' => 'Active (Accepting Donations)',
                                        'completed' => 'Completed / Goal Reached',
                                        'paused' => 'Paused',
                                    ])
                                    ->default('active')
                                    ->required(),
                                DatePicker::make('start_date')
                                    ->label('Campaign Launch Date')
                                    ->default(now())
                                    ->required(),
                                DatePicker::make('end_date')
                                    ->label('Target Deadline Date'),
                                TextInput::make('location')
                                    ->label('Field Location / District')
                                    ->placeholder('e.g. Varanasi & Mirzapur, Uttar Pradesh')
                                    ->maxLength(150),
                                TextInput::make('beneficiary_summary')
                                    ->label('Beneficiary Target Summary')
                                    ->placeholder('e.g. 500+ Children & 3 Grassroots Schools')
                                    ->maxLength(150),
                                TextInput::make('video_url')
                                    ->label('Cause Video Embed URL (YouTube/Vimeo)')
                                    ->url()
                                    ->placeholder('https://www.youtube.com/watch?v=...')
                                    ->maxLength(500),
                                Toggle::make('is_urgent')
                                    ->label('Mark as Urgent Cause')
                                    ->default(false),
                                Toggle::make('is_featured')
                                    ->label('Featured on Homepage')
                                    ->default(false),
                            ])->columns(2),

                        Tab::make('Story Narrative')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Textarea::make('short_description')
                                    ->label('Brief Summary Tagline')
                                    ->helperText('Appears on campaign cards and directory listings.')
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('full_story')
                                    ->label('Detailed Cause Story')
                                    ->helperText('Full narrative of the situation, emergency, and expected ground impact. Supports rich headings, formatted lists, tables, quotes, and media attachments.')
                                    ->toolbarButtons([
                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'highlight', 'clearFormatting'],
                                        ['h2', 'h3', 'lead', 'small'],
                                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList', 'horizontalRule', 'details'],
                                        ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
                                        ['table', 'attachFiles', 'link'],
                                        ['undo', 'redo'],
                                    ])
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('campaigns/story-attachments')
                                    ->fileAttachmentsVisibility('public')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Key Highlights')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Repeater::make('key_highlights')
                                    ->label('Key Highlights (Icon/Image + Text)')
                                    ->helperText('Displays the 4 key pillar cards under the cause story.')
                                    ->defaultItems(0)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Highlight Title')
                                            ->placeholder('e.g. School Admission Support')
                                            ->required(),
                                        Select::make('icon')
                                            ->label('Preset Icon')
                                            ->options([
                                                'graduation-cap' => '🎓 Graduation Cap (Education / School Admission)',
                                                'book-open' => '📖 Open Book (Books & Learning Materials)',
                                                'shirt' => '👕 Uniform / Shirt (Uniforms & School Facilities)',
                                                'users' => '👥 Users / Team (Mentoring & Career Guidance)',
                                                'heart' => '❤️ Heart / Medical (Healthcare & Patient Care)',
                                                'droplet' => '💧 Water Droplet (Clean Water Initiative)',
                                                'shield-check' => '🛡️ Shield Check (100% Verified & Tax Free)',
                                                'sparkles' => '✨ Sparkles (Special Impact / Emergency)',
                                                'custom' => '🖼️ Custom Upload (Use uploaded image below)',
                                            ])
                                            ->default('graduation-cap')
                                            ->required(),
                                        FileUpload::make('custom_icon')
                                            ->label('Custom Icon Image (Optional)')
                                            ->helperText('Upload SVG or PNG icon to override preset')
                                            ->disk('public')
                                            ->directory('campaigns/highlight-icons')
                                            ->image()
                                            ->maxSize(1024),
                                        TextInput::make('subtitle')
                                            ->label('Short Subtitle / Description (Optional)')
                                            ->placeholder('e.g. Annual fee and enrollment aid')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(3)
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Beneficiary Stories')
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Repeater::make('impact_stories')
                                    ->label('Beneficiary Impact Stories')
                                    ->helperText('Quotes and photos from children/beneficiaries helped by this cause.')
                                    ->defaultItems(0)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Beneficiary Name & Role')
                                            ->placeholder('e.g. Ayesha, 10th Grade')
                                            ->required(),
                                        Textarea::make('quote')
                                            ->label('Quote / Testimonial')
                                            ->placeholder('e.g. Because of this support, I can continue my education and dream of becoming a doctor.')
                                            ->rows(2)
                                            ->required(),
                                        FileUpload::make('photo')
                                            ->label('Photo')
                                            ->disk('public')
                                            ->directory('campaigns/impact')
                                            ->image()
                                            ->maxSize(2048),
                                    ])
                                    ->columns(3)
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Media & Gallery')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('thumbnail_image')
                                    ->label('Main Banner / Card Thumbnail')
                                    ->disk('public')
                                    ->directory('campaigns/thumbnails')
                                    ->image()
                                    ->maxSize(2048)
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->dehydrated(fn ($state) => filled($state)),
                                FileUpload::make('gallery_images')
                                    ->label('Photo Gallery / Impact Proof')
                                    ->disk('public')
                                    ->directory('campaigns/galleries')
                                    ->multiple()
                                    ->image()
                                    ->maxSize(2048),
                            ])->columns(2),

                        Tab::make('FAQs')
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                Repeater::make('faq_items')
                                    ->label('Frequently Asked Questions (FAQs)')
                                    ->defaultItems(0)
                                    ->schema([
                                        TextInput::make('question')
                                            ->label('Question')
                                            ->required(),
                                        Textarea::make('answer')
                                            ->label('Answer')
                                            ->rows(2)
                                            ->required(),
                                    ])
                                    ->columns(1)
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
