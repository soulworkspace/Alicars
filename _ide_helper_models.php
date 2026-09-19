<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $store_id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property numeric|null $price
 * @property string $price_type
 * @property string $currency
 * @property string|null $location
 * @property string|null $city
 * @property string $condition
 * @property string $status
 * @property string $template
 * @property bool $is_featured
 * @property \Illuminate\Support\Carbon|null $featured_until
 * @property int $views_count
 * @property int $favorites_count
 * @property string|null $contact_phone
 * @property string|null $contact_whatsapp
 * @property string|null $contact_messenger
 * @property bool $show_contact_info
 * @property bool $accept_offers
 * @property bool $is_negotiable
 * @property array<array-key, mixed>|null $seo_meta
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\FeaturedAd|null $featuredAd
 * @property-read string $condition_text
 * @property-read string|null $contact_whats_app_url
 * @property-read string $primary_image_url
 * @property-read string $share_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\AdImage|null $primaryImage
 * @property-read \App\Models\Store|null $store
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad byCategory($categoryId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad byCity($city)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad byPriceRange($min, $max)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad byTemplate($template)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereAcceptOffers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereContactMessenger($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereContactWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereFavoritesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereFeaturedUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereIsNegotiable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad wherePriceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereSeoMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereShowContactInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad whereViewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ad withoutTrashed()
 */
	class Ad extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $ad_id
 * @property string $image_path
 * @property int $sort_order
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage primary()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdImage whereUpdatedAt($value)
 */
	class AdImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $category_id
 * @property string $name
 * @property string $label
 * @property string $type
 * @property array<array-key, mixed>|null $options
 * @property bool $is_required
 * @property bool $is_filterable
 * @property int $sort_order
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ad> $ads
 * @property-read int|null $ads_count
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute filterable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereIsFilterable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attribute whereUpdatedAt($value)
 */
	class Attribute extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $icon
 * @property string|null $image
 * @property int|null $parent_id
 * @property string $type
 * @property int $sort_order
 * @property bool $is_active
 * @property bool $show_in_menu
 * @property array<array-key, mixed>|null $custom_fields
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ad> $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category menu()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category root()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCustomFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereShowInMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $ad_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Favorite whereUserId($value)
 */
	class Favorite extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $ad_id
 * @property string $position
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon $ends_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd category()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd header()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd sidebar()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FeaturedAd whereUpdatedAt($value)
 */
	class FeaturedAd extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $ad_id
 * @property int|null $sender_id
 * @property string $sender_name
 * @property string $sender_phone
 * @property string|null $sender_email
 * @property string $message
 * @property string $type
 * @property numeric|null $offer_amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ad $ad
 * @property-read string|null $whats_app_link
 * @property-read \App\Models\User|null $sender
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message buyRequests()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message inquiries()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message new()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message offers()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message read()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereAdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereOfferAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereSenderPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Message whereUpdatedAt($value)
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $buyer_id
 * @property int $listing_id
 * @property int $seller_id
 * @property string $size
 * @property string $color
 * @property int $quantity
 * @property numeric $total_price
 * @property string $status
 * @property string $phone
 * @property string $city
 * @property string $shipping_address
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $buyer
 * @property-read string $status_color
 * @property-read string $status_label
 * @property-read \App\Models\Ad $listing
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string $group
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting group($group)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $store_id
 * @property int $invited_by
 * @property string $email
 * @property string $token
 * @property array<array-key, mixed>|null $permissions
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property \Illuminate\Support\Carbon $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $inviter
 * @property-read \App\Models\Store $store
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation expired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereInvitedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StaffInvitation whereUpdatedAt($value)
 */
	class StaffInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $cover_image
 * @property string|null $phone
 * @property string|null $whatsapp
 * @property string|null $messenger
 * @property string|null $facebook
 * @property string|null $instagram
 * @property string|null $website
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property bool $is_verified
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $featured_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ad> $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StaffInvitation> $staffInvitations
 * @property-read int|null $staff_invitations_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store verified()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereFeaturedUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereMessenger($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Store whereWhatsapp($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * @method bool canCreateMoreAds()
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $bio
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ad> $ads
 * @property-read int|null $ads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StaffInvitation> $staffInvitations
 * @property-read int|null $staff_invitations_count
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User byRole($role)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

