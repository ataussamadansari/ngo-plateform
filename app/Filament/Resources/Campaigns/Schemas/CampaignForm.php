<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Campaign Essentials')
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
                            ->placeholder('e.g. 350+ Critical Patients & 4 Primary Health Centers')
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

                Section::make('Story & Media')
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
                        TagsInput::make('key_highlights')
                            ->label('Key Highlights / Guarantees')
                            ->placeholder('e.g. 100% Tax Exemption, Direct Manufacturer Procurement')
                            ->columnSpanFull(),
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
                        Repeater::make('impact_stories')
                            ->label('Beneficiary Impact Stories')
                            ->defaultItems(0)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Beneficiary Name & Role')
                                    ->placeholder('e.g. Ayesha, 10th Grade')
                                    ->required(),
                                Textarea::make('quote')
                                    ->label('Quote / Testimonial')
                                    ->rows(2)
                                    ->required(),
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->disk('public')
                                    ->directory('campaigns/impact')
                                    ->image()
                                    ->maxSize(2048),
                            ])
                            ->columns(1)
                            ->collapsible()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
