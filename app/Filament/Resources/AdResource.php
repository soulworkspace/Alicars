<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Filament\Resources\AdResource\RelationManagers;
use App\Models\Ad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'الإعلانات';
    protected static ?string $navigationGroup = 'إدارة المحتوى';
    protected static ?string $modelLabel = 'إعلان';
    protected static ?string $pluralModelLabel = 'الإعلانات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('معلومات أساسية')
                    ->schema([
                        Select::make('user_id')
                            ->label('المستخدم')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('store_id')
                            ->label('المتجر')
                            ->relationship('store', 'name')
                            ->searchable()
                            ->nullable(),
                        Select::make('category_id')
                            ->label('الفئة')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('template')
                            ->label('القالب')
                            ->options([
                                'real_estate' => 'عقارات',
                                'car' => 'سيارات',
                                'general' => 'عام',
                            ])
                            ->required()
                            ->default('general'),
                    ])->columns(2),

                Section::make('تفاصيل الإعلان')
                    ->schema([
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('price')
                            ->label('السعر')
                            ->numeric()
                            ->prefix('د.ج'),
                        Select::make('price_type')
                            ->label('نوع السعر')
                            ->options([
                                'fixed' => 'ثابت',
                                'negotiable' => 'قابل للتفاوض',
                                'free' => 'مجاني',
                            ])
                            ->required()
                            ->default('fixed'),
                        Select::make('condition')
                            ->label('الحالة')
                            ->options([
                                'new' => 'جديد',
                                'used' => 'مستعمل',
                                'refurbished' => 'مجدد',
                            ])
                            ->required()
                            ->default('used'),
                    ])->columns(2),

                Section::make('الموقع')
                    ->schema([
                        TextInput::make('location')
                            ->label('الموقع')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->label('المدينة')
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('معلومات الاتصال')
                    ->schema([
                        TextInput::make('contact_phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('contact_whatsapp')
                            ->label('واتساب')
                            ->maxLength(20),
                        TextInput::make('contact_messenger')
                            ->label('ماسنجر')
                            ->maxLength(50),
                        Toggle::make('show_contact_info')
                            ->label('إظهار معلومات الاتصال')
                            ->default(true),
                        Toggle::make('accept_offers')
                            ->label('قبول العروض'),
                        Toggle::make('is_negotiable')
                            ->label('قابل للتفاوض'),
                    ])->columns(3),

                Section::make('الحالة والنشر')
                    ->schema([
                        Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'pending' => 'قيد المراجعة',
                                'active' => 'نشط',
                                'rejected' => 'مرفوض',
                                'sold' => 'تم البيع',
                                'archived' => 'مؤرشف',
                            ])
                            ->required()
                            ->default('pending'),
                        Toggle::make('is_featured')
                            ->label('إعلان مميز'),
                        DateTimePicker::make('featured_until')
                            ->label('انتهاء التمييز')
                            ->nullable(),
                        DateTimePicker::make('published_at')
                            ->label('تاريخ النشر')
                            ->nullable(),
                        DateTimePicker::make('expires_at')
                            ->label('تاريخ الانتهاء')
                            ->nullable(),
                    ])->columns(3),

                Section::make('SEO')
                    ->schema([
                        KeyValue::make('seo_meta')
                            ->label('ميتا بيانات SEO')
                            ->keyLabel('المفتاح')
                            ->valueLabel('القيمة')
                            ->columnSpanFull(),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(30)
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('الفئة')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('المعلن')
                    ->sortable(),
                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'active',
                        'danger' => 'rejected',
                        'primary' => 'sold',
                        'secondary' => 'archived',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد المراجعة',
                        'active' => 'نشط',
                        'rejected' => 'مرفوض',
                        'sold' => 'تم البيع',
                        'archived' => 'مؤرشف',
                        default => $state,
                    }),
                BadgeColumn::make('template')
                    ->label('القالب')
                    ->colors([
                        'primary' => 'real_estate',
                        'success' => 'car',
                        'secondary' => 'general',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'real_estate' => 'عقارات',
                        'car' => 'سيارات',
                        'general' => 'عام',
                        default => $state,
                    }),
                TextColumn::make('price')
                    ->label('السعر')
                    ->money('DZD')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                TextColumn::make('views_count')
                    ->label('المشاهدات')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'قيد المراجعة',
                        'active' => 'نشط',
                        'rejected' => 'مرفوض',
                        'sold' => 'تم البيع',
                        'archived' => 'مؤرشف',
                    ]),
                SelectFilter::make('template')
                    ->label('القالب')
                    ->options([
                        'real_estate' => 'عقارات',
                        'car' => 'سيارات',
                        'general' => 'عام',
                    ]),
                SelectFilter::make('category_id')
                    ->label('الفئة')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
