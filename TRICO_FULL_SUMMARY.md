# ملخص مشروع TRICO (Multi-Vendor Marketplace)

## 1. هيكل قاعدة البيانات (Migrations)
### File: database/migrations/0001_01_01_000000_create_users_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

```
### File: database/migrations/0001_01_01_000001_create_cache_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};

```
### File: database/migrations/0001_01_01_000002_create_jobs_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};

```
### File: database/migrations/2026_02_19_150607_create_permission_tables.php
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            //$table->engine('InnoDB');
            $table->bigIncrements('id'); // permission id
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            //$table->engine('InnoDB');
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MyISAM use string('name', 225); // (or 166 for InnoDB with Redundant/Compact row format)
            $table->string('guard_name'); // For MyISAM use string('guard_name', 25);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
            $table->unsignedBigInteger($pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
            $table->unsignedBigInteger($pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};

```
### File: database/migrations/2026_02_19_150702_create_stores_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('messenger')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Algeria');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('featured_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};

```
### File: database/migrations/2026_02_19_150715_create_categories_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->enum('type', ['real_estate', 'car', 'general'])->default('general');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('show_in_menu')->default(true);
            $table->json('custom_fields')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

```
### File: database/migrations/2026_02_19_150720_create_ads_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('price_type', ['fixed', 'negotiable', 'free'])->default('fixed');
            $table->enum('currency', ['DZD', 'USD', 'EUR'])->default('DZD');
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('used');
            $table->enum('status', ['pending', 'active', 'rejected', 'sold', 'archived'])->default('pending');
            $table->enum('template', ['real_estate', 'car', 'general'])->default('general');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_messenger')->nullable();
            $table->boolean('show_contact_info')->default(true);
            $table->boolean('accept_offers')->default(false);
            $table->boolean('is_negotiable')->default(false);
            $table->json('seo_meta')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};

```
### File: database/migrations/2026_02_19_150739_create_ad_images_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ad_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_images');
    }
};

```
### File: database/migrations/2026_02_19_150748_create_attributes_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('label');
            $table->enum('type', ['text', 'number', 'select', 'checkbox', 'date', 'boolean'])->default('text');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};

```
### File: database/migrations/2026_02_19_150757_create_ad_attributes_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ad_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
            $table->text('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_attributes');
    }
};

```
### File: database/migrations/2026_02_19_150811_create_messages_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_email')->nullable();
            $table->text('message');
            $table->enum('type', ['inquiry', 'offer', 'buy_request'])->default('inquiry');
            $table->decimal('offer_amount', 15, 2)->nullable();
            $table->enum('status', ['new', 'read', 'replied', 'converted'])->default('new');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

```
### File: database/migrations/2026_02_19_150816_create_settings_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('type')->default('text');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

```
### File: database/migrations/2026_02_19_150829_create_featured_ads_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('featured_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->enum('position', ['header', 'sidebar', 'category'])->default('header');
            $table->integer('sort_order')->default(0);
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_ads');
    }
};

```
### File: database/migrations/2026_02_19_151010_add_role_to_users_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->text('address')->nullable()->after('whatsapp');
            $table->string('avatar')->nullable()->after('address');
            $table->enum('role', ['admin', 'vendor', 'staff', 'buyer'])->default('buyer')->after('avatar');
            $table->boolean('is_active')->default(true)->after('role');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'whatsapp', 'address', 'avatar', 'role', 'is_active', 'last_login_at']);
        });
    }
};

```
### File: database/migrations/2026_02_19_151035_create_staff_invitations_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('invited_by')->constrained('users')->onDelete('cascade');
            $table->string('email');
            $table->string('token')->unique();
            $table->json('permissions')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_invitations');
    }
};

```
### File: database/migrations/2026_02_21_043047_create_favorites_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['user_id', 'ad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};

```
### File: database/migrations/2026_02_21_043732_add_bio_to_users_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bio');
        });
    }
};

```
### File: database/migrations/2026_02_21_044754_create_notifications_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

```

## 2. نماذج البيانات والعلاقات (Models)
### Model: app/Models/Ad.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'store_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'price_type',
        'currency',
        'location',
        'city',
        'condition',
        'status',
        'template',
        'is_featured',
        'featured_until',
        'views_count',
        'favorites_count',
        'contact_phone',
        'contact_whatsapp',
        'contact_messenger',
        'show_contact_info',
        'accept_offers',
        'is_negotiable',
        'seo_meta',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'show_contact_info' => 'boolean',
        'accept_offers' => 'boolean',
        'is_negotiable' => 'boolean',
        'seo_meta' => 'array',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'featured_until' => 'datetime',
    ];

    // --- Accessors المضافة لدعم واجهة TRICO ---

    /**
     * جلب رابط الصورة الأساسية للإعلان
     * يستخدم العلاقة primaryImage إذا وجدت، وإلا يجلب أول صورة، أو صورة افتراضية
     */
    public function getPrimaryImageUrlAttribute(): string
    {
        // 1. محاولة جلب الصورة المحددة كأساسية
        if ($this->primaryImage) {
            return asset('storage/' . $this->primaryImage->image_path);
        }

        // 2. محاولة جلب أول صورة مرتبطة بالإعلان
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return asset('storage/' . $firstImage->image_path);
        }

        // 3. صورة افتراضية في حال عدم وجود صور
        return 'https://via.placeholder.com/400x600?text=TRICO+Fashion';
    }

    /**
     * تحويل الحالة (Condition) إلى نص عربي للعرض
     */
    public function getConditionTextAttribute(): string
    {
        return $this->condition === 'new' ? 'جديد' : 'مستعمل';
    }

    // --- العلاقات (Relations) ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(AdImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(AdImage::class)->where('is_primary', true);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'ad_attributes')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function featuredAd(): BelongsTo
    {
        return $this->belongsTo(FeaturedAd::class);
    }

    // --- النطاقات (Scopes) ---

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->whereNotNull('featured_until')
            ->where('featured_until', '>', now());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByTemplate($query, $template)
    {
        return $query->where('template', $template);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->when($min, fn($q) => $q->where('price', '>=', $min))
            ->when($max, fn($q) => $q->where('price', '<=', $max));
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    // --- دوال المساعدة (Helper Methods) ---

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getContactWhatsAppUrlAttribute(): ?string
    {
        if ($this->contact_whatsapp) {
            $phone = preg_replace('/[^0-9]/', '', $this->contact_whatsapp);
            return "https://wa.me/{$phone}";
        }
        return null;
    }

    public function getShareUrlAttribute(): string
    {
        return route('ads.show', $this->slug);
    }
}
```
### Model: app/Models/AdImage.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'image_path',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
}

```
### Model: app/Models/Attribute.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'label',
        'type',
        'options',
        'is_required',
        'is_filterable',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ads(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class, 'ad_attributes')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}

```
### Model: app/Models/Category.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'parent_id',
        'type',
        'sort_order',
        'is_active',
        'show_in_menu',
        'custom_fields',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_menu' => 'boolean',
        'custom_fields' => 'array',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeMenu($query)
    {
        return $query->where('show_in_menu', true)->orderBy('sort_order');
    }
}

```
### Model: app/Models/Favorite.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ad_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}

```
### Model: app/Models/FeaturedAd.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'position',
        'sort_order',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function scopeHeader($query)
    {
        return $query->where('position', 'header');
    }

    public function scopeSidebar($query)
    {
        return $query->where('position', 'sidebar');
    }

    public function scopeCategory($query)
    {
        return $query->where('position', 'category');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function isExpired(): bool
    {
        return $this->ends_at < now();
    }
}

```
### Model: app/Models/Message.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'sender_id',
        'sender_name',
        'sender_phone',
        'sender_email',
        'message',
        'type',
        'offer_amount',
        'status',
        'read_at',
    ];

    protected $casts = [
        'offer_amount' => 'decimal:2',
        'read_at' => 'datetime',
    ];

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeInquiries($query)
    {
        return $query->where('type', 'inquiry');
    }

    public function scopeOffers($query)
    {
        return $query->where('type', 'offer');
    }

    public function scopeBuyRequests($query)
    {
        return $query->where('type', 'buy_request');
    }

    public function markAsRead(): void
    {
        $this->update([
            'status' => 'read',
            'read_at' => now(),
        ]);
    }

    public function markAsReplied(): void
    {
        $this->update(['status' => 'replied']);
    }

    public function getWhatsAppLinkAttribute(): ?string
    {
        if ($this->sender_phone) {
            $phone = preg_replace('/[^0-9]/', '', $this->sender_phone);
            return "https://wa.me/{$phone}";
        }
        return null;
    }
}

```
### Model: app/Models/Setting.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'description',
    ];

    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $group = 'general', $type = 'text', $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    public static function getUiSettings(): array
    {
        return [
            'primary_color' => self::get('primary_color', '#ef4444'),
            'secondary_color' => self::get('secondary_color', '#3b82f6'),
            'site_name' => self::get('site_name', 'OuedKniss Clone'),
            'site_logo' => self::get('site_logo'),
            'site_favicon' => self::get('site_favicon'),
            'hero_title' => self::get('hero_title', 'ابحث عن ما تحتاجه'),
            'hero_subtitle' => self::get('hero_subtitle', 'آلاف الإعلانات بانتظارك'),
            'hero_image' => self::get('hero_image'),
            'show_featured_section' => self::get('show_featured_section', true),
            'show_popular_categories' => self::get('show_popular_categories', true),
            'show_recent_ads' => self::get('show_recent_ads', true),
            'footer_text' => self::get('footer_text'),
            'contact_email' => self::get('contact_email'),
            'contact_phone' => self::get('contact_phone'),
            'social_facebook' => self::get('social_facebook'),
            'social_instagram' => self::get('social_instagram'),
            'social_twitter' => self::get('social_twitter'),
        ];
    }
}

```
### Model: app/Models/StaffInvitation.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'invited_by',
        'email',
        'token',
        'permissions',
        'accepted_at',
        'expires_at',
    ];

    protected $casts = [
        'permissions' => 'array',
        'accepted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function scopePending($query)
    {
        return $query->whereNull('accepted_at')
            ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function isAccepted(): bool
    {
        return !is_null($this->accepted_at);
    }

    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    public function markAsAccepted(): void
    {
        $this->update(['accepted_at' => now()]);
    }
}

```
### Model: app/Models/Store.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Store extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'cover_image',
        'phone',
        'whatsapp',
        'messenger',
        'facebook',
        'instagram',
        'website',
        'address',
        'city',
        'country',
        'is_verified',
        'is_active',
        'featured_until',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'featured_until' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function staffInvitations(): HasMany
    {
        return $this->hasMany(StaffInvitation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->whereNotNull('featured_until')
            ->where('featured_until', '>', now());
    }
}

```
### Model: app/Models/User.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method bool canCreateMoreAds()
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'whatsapp',
        'address',
        'bio',
        'avatar',
        'role',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function staffInvitations(): HasMany
    {
        return $this->hasMany(StaffInvitation::class, 'invited_by');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    public function isVendor(): bool
    {
        return $this->role === 'vendor' || $this->hasRole('vendor');
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff' || $this->hasRole('staff');
    }

    public function isBuyer(): bool
    {
        return $this->role === 'buyer' || $this->hasRole('buyer');
    }

    public function hasStore(): bool
    {
        return $this->store !== null;
    }

    public function canCreateStore(): bool
    {
        return !$this->hasStore() && ($this->isVendor() || $this->isAdmin());
    }

    public function getAdsCount(): int
    {
        return $this->ads()->count();
    }

    public function canCreateMoreAds(): bool
    {
        return $this->getAdsCount() < 30 || $this->isAdmin();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function markLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }
}

```

## 3. مسارات النظام (Routes)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdController,
    CategoryController,
    StoreController,
    DashboardController,
    MessageController,
    FavoriteController,
    NotificationController,
    SearchController,
    ProfileController,
    StoreSetupController,
    VendorDashboardController
};
use App\Livewire\{Home, AdListing};

// --- 1. Public Routes ---
Route::get('/', Home::class)->name('home');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Categories & Stores
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

// Ads (قمت بترتيبها لمنع التضارب)
Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
Route::get('/category/{slug}', AdListing::class)->name('ads.by-category');
// ملاحظة: تأكد أن {slug} في الأسفل لا يتعارض مع المسارات الثابتة
Route::get('/ads/{slug}', [AdController::class, 'show'])->name('ads.show');


// --- 2. Authenticated Routes ---
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
        Route::get('/activity', [DashboardController::class, 'activity'])->name('dashboard.activity');
    });

    // Ads Management
    Route::get('/my-ads', [AdController::class, 'myAds'])->name('my-ads');
    Route::get('/ads/create/new', [AdController::class, 'create'])->name('ads.create'); // تم تغيير المسار قليلاً لمنع التضارب مع {slug}
    Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');

    // Messaging
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/conversation', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/', [MessageController::class, 'store'])->name('messages.store');
        Route::post('/start/{user}', [MessageController::class, 'start'])->name('messages.start');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
    });

    // Favorites & Notifications
    Route::post('/favorites/{ad}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{ad}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Profile Settings
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::put('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Store Setup (للمستخدمين العاديين ليصبحوا تجار)
    Route::prefix('store-setup')->group(function () {
        Route::get('/', [StoreSetupController::class, 'index'])->name('store.setup');
        Route::post('/basic', [StoreSetupController::class, 'storeBasic'])->name('store.setup.basic');
        Route::post('/branding', [StoreSetupController::class, 'storeBranding'])->name('store.setup.branding');
        Route::post('/contact', [StoreSetupController::class, 'storeContact'])->name('store.setup.contact');
    });

    // Vendor Panel (للتجار فقط)
    Route::prefix('vendor')->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
        Route::get('/analytics', [VendorDashboardController::class, 'analytics'])->name('vendor.analytics');
        Route::get('/ads/manage', [VendorDashboardController::class, 'manageAds'])->name('vendor.ads.manage');
        Route::get('/store/settings', [VendorDashboardController::class, 'storeSettings'])->name('vendor.store.settings');
        Route::put('/store', [VendorDashboardController::class, 'updateStore'])->name('vendor.store.update');
    });
});

// --- 3. Static Pages ---
Route::view('/help', 'pages.help')->name('help');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/safety', 'pages.safety')->name('safety');

// Auth
require __DIR__.'/auth.php';
```

## 4. منطق التحكم الأساسي (Controllers)
### Controller: app/Http/Controllers/AdController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class AdController extends Controller
{
    /**
     * عرض المتجر العالمي (دمج الحقيقي والوهمي)
     */
    public function index(Request $request)
{
    // جلب الإعلانات النشطة مع العلاقات (Category) لتحسين الأداء (Eager Loading)
    $ads = Ad::with('category')
        ->where('status', 'active') // عرض الإعلانات النشطة فقط
        ->latest() // الأحدث أولاً
        ->paginate(12); // تقسيم الصفحات (Pagination)

    return view('ads.index', compact('ads'));
}

    /**
     * صفحة إنشاء إعلان جديد
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // التحقق من صلاحية المستخدم للنشر (الحد الأقصى 30 كما في المودل)
        if (!$user->canCreateMoreAds()) {
            return redirect()->route('ads.index')
                ->with('error', 'لقد وصلت للحد الأقصى من الإعلانات المسموح بها (30 إعلاناً).');
        }

        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('ads.create', compact('categories'));
    }

    /**
     * حفظ الإعلان في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:fixed,negotiable,free',
            'condition' => 'required|in:new,used,refurbished',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_whatsapp' => 'nullable|string|max:20',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $ad = Ad::create([
            ...$validated,
            'slug' => Str::slug($validated['title']),
            'user_id' => Auth::id(),
            'store_id' => $user->store?->id,
            'status' => 'pending', // يحتاج مراجعة الإدارة أولاً
            'template' => $this->getTemplateForCategory($request->category_id),
        ]);

        // معالجة الصور المرفوعة
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('ads/' . $ad->id, 'public');
                $ad->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('ads.show', $ad->slug)
            ->with('success', 'تم نشر إعلانك بنجاح! سيظهر للجميع بعد مراجعة الإدارة.');
    }

    /**
     * عرض تفاصيل منتج معين
     */
    public function show($slug)
    {
        $ad = Ad::where('slug', $slug)
            ->with(['user', 'store', 'category', 'images', 'attributes'])
            ->firstOrFail();

        $ad->incrementViews();

        return view('ads.show', compact('ad'));
    }

    /**
     * تعديل إعلان موجود
     */
    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);
        $categories = Category::active()->root()->with('children')->get();
        return view('ads.edit', compact('ad', 'categories'));
    }

    /**
     * تحديث البيانات في قاعدة البيانات
     */
    public function update(Request $request, Ad $ad)
{
    // 1. التحقق من الصلاحية (Security Check)
    // نضمن أن البائع الحالي هو فقط من يمكنه تعديل إعلانه
    if (auth()->id() !== $ad->user_id) {
        return redirect()->route('my-ads')->with('error', 'غير مسموح لك بتعديل هذا الإعلان.');
    }

    // 2. التحقق من البيانات المدخلة (Validation)
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|min:10',
        'price' => 'nullable|numeric|min:0',
        'city' => 'nullable|string|max:100',
        'condition' => 'required|in:new,used',
        'contact_phone' => 'nullable|string|max:20',
        'is_negotiable' => 'nullable', // سنتعامل معه كـ boolean بالأسفل
    ]);

    // 3. معالجة الـ Checkbox (لأن الـ checkbox لا يرسل قيمة إذا لم يتم تحديده)
    $validated['is_negotiable'] = $request->has('is_negotiable');

    // 4. تنفيذ التحديث في قاعدة البيانات
    try {
        $ad->update($validated);
        
        // إذا نجح التحديث، نعود لصفحة التعديل مع رسالة نجاح
        return redirect()->route('ads.edit', $ad->id)->with('success', 'تم تحديث بيانات الإعلان بنجاح ✨');
    } catch (\Exception $e) {
        // في حال حدوث خطأ تقني غير متوقع
        return back()->with('error', 'حدث خطأ أثناء التحديث، يرجى المحاولة لاحقاً.');
    }
}

    /**
     * حذف الإعلان
     */
    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);
        $ad->delete();

        return redirect()->route('my-ads')
            ->with('success', 'تم حذف الإعلان نهائياً.');
    }

    /**
     * عرض إعلانات المستخدم الحالي
     */
    public function myAds()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $ads = $user->ads()
            ->with('category', 'images')
            ->latest()
            ->paginate(20);

        return view('ads.my-ads', compact('ads'));
    }

    /**
     * دالة داخلية لتوليد منتجات وهمية (Fake Ads) بستايل TRICO العالمي
     */
    private function generateGlobalFakeAds()
    {
        $fakes = collect();
        $brands = ['Gucci', 'Nike Air', 'Zara Man', 'Adidas Original', 'Prada Sport', 'Louis Vuitton', 'H&M Trend', 'Balenciaga'];
        $cities = ['الجزائر العاصمة', 'وهران', 'سطيف', 'قسنطينة', 'بجاية', 'عنابة'];
        $categories = ['قمصان فاخرة', 'أحذية رياضية', 'ساعات يد', 'بدلات رسمية', 'حقائب جلدية'];
        
        for ($i = 1; $i <= 35; $i++) {
            $brand = $brands[array_rand($brands)];
            $catName = $categories[array_rand($categories)];
            
            $fakes->push((object)[
                'id' => 9000 + $i,
                'title' => "$brand - $catName إصدار " . (2025 + (rand(0,1))),
                'slug' => "global-trico-product-$i",
                'description' => "قطعة أصلية من مجموعة $brand الجديدة. جودة عالمية مضمونة.",
                'price' => rand(5500, 120000),
                'price_type' => 'fixed',
                'condition' => 'new',
                'condition_text' => 'جديد',
                'city' => $cities[array_rand($cities)],
                'status' => 'active',
                // استخدام صور عشوائية عالية الجودة
                'primary_image_url' => "https://picsum.photos/seed/trico" . ($i + 100) . "/600/800",
                'category' => (object)['name' => $catName],
                'user' => (object)['name' => 'Verified Global Seller'],
                'store' => (object)['name' => 'TRICO Global'],
                'created_at' => now()->subDays(rand(1, 15)),
                'views_count' => rand(100, 5000)
            ]);
        }
        return $fakes;
    }

    /**
     * تحديد القالب المناسب بناءً على الفئة
     */
    private function getTemplateForCategory($categoryId)
    {
        $category = Category::find($categoryId);
        return $category?->type ?? 'general';
    }
}
```
### Controller: app/Http/Controllers/CategoryController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::root()->active()->with('children')->get();
        return view('categories.index', compact('categories'));
    }
}

```
### Controller: app/Http/Controllers/Controller.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}

```
### Controller: app/Http/Controllers/DashboardController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Stats
        $stats = [
            'total_ads' => $user->ads()->count(),
            'active_ads' => $user->ads()->where('status', 'active')->count(),
            'pending_ads' => $user->ads()->where('status', 'pending')->count(),
            'total_views' => $user->ads()->sum('views_count') ?? 0,
            'unread_messages' => $user->messages()->whereNull('read_at')->count(),
            'favorites_count' => $user->favorites()->count() ?? 0,
        ];
        
        // Recent ads
        $recentAds = $user->ads()
            ->with('category', 'images')
            ->latest()
            ->take(5)
            ->get();
        
        // Recent messages
        $recentMessages = $user->messages()
            ->with('sender', 'ad')
            ->whereNull('read_at')
            ->latest()
            ->take(5)
            ->get();
        
        // Recent activity
        $activity = $this->getRecentActivity($user);
        
        // Store stats for vendors
        $storeStats = null;
        if ($user->hasStore()) {
            $storeStats = [
                'store_views' => $user->store->views_count ?? 0,
                'store_ads' => $user->store->ads()->count(),
                'featured_ads' => $user->store->ads()->where('is_featured', true)->count(),
            ];
        }
        
        return view('dashboard.index', compact(
            'stats', 
            'recentAds', 
            'recentMessages', 
            'activity',
            'storeStats'
        ));
    }
    
    public function stats()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Get stats by month for charts
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $month->format('M'),
                'ads' => $user->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'views' => $user->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('views_count') ?? 0,
            ];
        }
        
        // Category breakdown
        $categoryStats = $user->ads()
            ->selectRaw('category_id, count(*) as count')
            ->with('category:id,name')
            ->groupBy('category_id')
            ->get();
        
        return view('dashboard.stats', compact('monthlyStats', 'categoryStats'));
    }
    
    public function activity()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $activities = $this->getRecentActivity($user, 50);
        
        return view('dashboard.activity', compact('activities'));
    }
    
    private function getRecentActivity($user, $limit = 10)
    {
        $activities = [];
        
        // Recent ads
        $ads = $user->ads()
            ->select('id', 'title', 'slug', 'status', 'created_at', 'updated_at')
            ->latest()
            ->take($limit)
            ->get();
        
        foreach ($ads as $ad) {
            $activities[] = [
                'type' => 'ad',
                'title' => $ad->title,
                'status' => $ad->status,
                'date' => $ad->created_at,
                'url' => route('ads.show', $ad->slug),
            ];
        }
        
        // Recent messages
        $messages = $user->messages()
            ->with('sender')
            ->latest()
            ->take($limit)
            ->get();
        
        foreach ($messages as $message) {
            $activities[] = [
                'type' => 'message',
                'title' => 'رسالة من ' . $message->sender->name,
                'status' => $message->read_at ? 'read' : 'unread',
                'date' => $message->created_at,
                'url' => route('messages.index'),
            ];
        }
        
        // Sort by date
        usort($activities, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });
        
        return array_slice($activities, 0, $limit);
    }
}

```
### Controller: app/Http/Controllers/FavoriteController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['ad.category', 'ad.images', 'ad.user'])
            ->latest()
            ->paginate(20);
        
        // Group by category for better organization
        $groupedFavorites = $favorites->groupBy(function ($favorite) {
            return $favorite->ad->category?->name ?? 'عام';
        });
        
        return view('favorites.index', compact('favorites', 'groupedFavorites'));
    }
    
    public function store(Ad $ad)
    {
        $user = auth()->user();
        
        // Check if already favorited
        if ($user->favorites()->where('ad_id', $ad->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'الإعلان موجود بالفعل في المفضلة',
            ], 422);
        }
        
        $user->favorites()->create(['ad_id' => $ad->id]);
        
        return response()->json([
            'success' => true,
            'message' => 'تمت الإضافة إلى المفضلة',
        ]);
    }
    
    public function destroy(Ad $ad)
    {
        $user = auth()->user();
        
        $user->favorites()->where('ad_id', $ad->id)->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت الإزالة من المفضلة',
            ]);
        }
        
        return redirect()->route('favorites.index')->with('success', 'تمت الإزالة من المفضلة');
    }
}

```
### Controller: app/Http/Controllers/MessageController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Message::select('sender_id', 'ad_id')
            ->selectRaw('MAX(created_at) as last_message_at')
            ->selectRaw('COUNT(*) as message_count')
            ->where('recipient_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->with(['sender:id,name,avatar', 'ad:id,title,slug'])
            ->groupBy('sender_id', 'ad_id')
            ->orderByDesc('last_message_at')
            ->get();
        
        return view('messages.index', compact('conversations'));
    }
    
    public function show(Request $request)
    {
        $otherUserId = $request->query('user');
        $adId = $request->query('ad');
        
        if (!$otherUserId) {
            return redirect()->route('messages.index');
        }
        
        $otherUser = User::findOrFail($otherUserId);
        
        $messages = Message::where(function ($query) use ($otherUserId) {
                $query->where('sender_id', Auth::id())
                      ->where('recipient_id', $otherUserId);
            })
            ->orWhere(function ($query) use ($otherUserId) {
                $query->where('sender_id', $otherUserId)
                      ->where('recipient_id', Auth::id());
            })
            ->when($adId, function ($query) use ($adId) {
                $query->where('ad_id', $adId);
            })
            ->with(['sender:id,name,avatar'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark messages as read
        Message::where('sender_id', $otherUserId)
            ->where('recipient_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        $ad = $adId ? Ad::find($adId) : null;
        
        return view('messages.show', compact('messages', 'otherUser', 'ad'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'ad_id' => 'nullable|exists:ads,id',
            'content' => 'required|string|max:5000',
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $validated['recipient_id'],
            'ad_id' => $validated['ad_id'] ?? null,
            'content' => $validated['content'],
        ]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }
        
        return back()->with('success', 'تم إرسال الرسالة بنجاح');
    }
    
    public function start(Request $request, User $user)
    {
        $adId = $request->query('ad');
        
        return redirect()->route('messages.show', [
            'user' => $user->id,
            'ad' => $adId,
        ]);
    }
    
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        
        $message->delete();
        
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }
}

```
### Controller: app/Http/Controllers/NotificationController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function markRead($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
        }
        
        return response()->json(['success' => true]);
    }
    
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }
    
    public function destroy($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->delete();
        }
        
        return back()->with('success', 'تم حذف الإشعار');
    }
}

```
### Controller: app/Http/Controllers/ProfileController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('profile.edit')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
    
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        $path = $request->file('avatar')->store('avatars/' . $user->id, 'public');
        
        $user->update(['avatar' => $path]);
        
        return redirect()->route('profile.edit')->with('success', 'تم تحديث الصورة الشخصية بنجاح');
    }
    
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
        }
        
        // Soft delete - mark as inactive
        $user->update(['is_active' => false]);
        
        Auth::logout();
        
        return redirect()->route('home')->with('success', 'تم حذف حسابك بنجاح');
    }
}

```
### Controller: app/Http/Controllers/SearchController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // استخدام Eager Loading لتحسين الأداء ومنع مشكلة N+1
        $query = Ad::query()->with(['category', 'images', 'user'])
            ->where('status', 'active');

        // 1. منطق البحث النصي الذكي
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%");
            });

            // "اللمسة الذكية": ترتيب النتائج بحيث يظهر الإعلان الذي يحتوي الكلمة في العنوان أولاً
            $query->orderByRaw("CASE 
                WHEN title LIKE ? THEN 1 
                WHEN description LIKE ? THEN 2 
                ELSE 3 END", ["%{$searchTerm}%", "%{$searchTerm}%"]);
        }

        // 2. فلاتر التصنيف (دعم الـ ID والـ Slug)
        if ($request->filled('category')) {
            $categoryParam = $request->category;
            $query->whereHas('category', function ($q) use ($categoryParam) {
                $q->where('slug', $categoryParam)
                  ->orWhere('id', $categoryParam);
            });
        }

        // 3. نطاق السعر (Price Range)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. حالة المنتج والمدينة
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // 5. منطق الترتيب (Sorting)
        // إذا لم يوجد بحث نصي، نستخدم الترتيب المختار أو الافتراضي
        if (!$request->filled('q')) {
            $sort = $request->get('sort', 'newest');
            switch ($sort) {
                case 'oldest': $query->oldest(); break;
                case 'price_low': $query->orderBy('price', 'asc'); break;
                case 'price_high': $query->orderBy('price', 'desc'); break;
                default: $query->latest();
            }
        }

        // تنفيذ الاستعلام مع الترقيم التلقائي
        $ads = $query->paginate(24)->withQueryString();

        // جلب البيانات للفلاتر الجانبية (تحسين الأداء عبر الكاش أو الاستعلام المباشر)
        $categories = Category::active()->root()->with('children')->get();
        
        $cities = Ad::where('status', 'active')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();

        return view('search.index', compact('ads', 'categories', 'cities'));
    }

    /**
     * الاقتراحات الذكية أثناء الكتابة (AJAX)
     */
    public function suggestions(Request $request)
    {
        $searchTerm = $request->get('q');
        
        if (strlen($searchTerm) < 2) {
            return response()->json([]);
        }

        $suggestions = Ad::where('status', 'active')
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('city', 'like', "%{$searchTerm}%");
            })
            ->select('title', 'slug', 'price')
            ->limit(8) // زيادة العدد قليلاً لتجربة أفضل
            ->get();

        return response()->json($suggestions);
    }
}
```
### Controller: app/Http/Controllers/StoreController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        // استخدام withCount('ads') لجلب عدد الإعلانات بكفاءة عالية
        $stores = Store::where('is_active', true)
            ->withCount('ads') 
            ->latest()
            ->paginate(12); // 12 رقم مثالي لتقسيم الشبكة (3 أعمدة أو 4)

        return view('stores.index', compact('stores'));
    }

    public function show($slug)
    {
        // جلب المتجر مع الإعلانات وصورها الأساسية في استعلام واحد
        $store = Store::where('slug', $slug)
            ->withCount('ads')
            ->with(['user', 'ads' => function ($query) {
                $query->active()
                      ->with('primaryImage') // تأكد من تحميل الصورة الأساسية لتجنب البطء
                      ->latest();
            }])
            ->firstOrFail();

        return view('stores.show', compact('store'));
    }
}
```
### Controller: app/Http/Controllers/StoreSetupController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Str;

class StoreSetupController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->canCreateStore()) {
            return redirect()->route('dashboard')->with('error', 'لا يمكنك إنشاء متجر');
        }
        
        return view('store.setup');
    }
    
    public function storeBasic(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->canCreateStore()) {
            return redirect()->route('dashboard')->with('error', 'لا يمكنك إنشاء متجر');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:stores,name',
            'description' => 'nullable|string|max:1000',
        ]);
        
        $store = Store::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => true,
            'is_verified' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'store' => $store,
            'message' => 'تم إنشاء المتجر بنجاح',
        ]);
    }
    
    public function storeBranding(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'المتجر غير موجود'], 404);
        }
        
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
        ]);
        
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $store->update(['logo' => $logoPath]);
        }
        
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('stores/covers', 'public');
            $store->update(['cover_image' => $coverPath]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث صور المتجر',
        ]);
    }
    
    public function storeContact(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return response()->json(['success' => false, 'message' => 'المتجر غير موجود'], 404);
        }
        
        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'messenger' => 'nullable|string|max:50',
            'facebook' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);
        
        $store->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث معلومات الاتصال',
        ]);
    }
}

```
### Controller: app/Http/Controllers/VendorDashboardController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Carbon\Carbon;

class VendorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        // Store stats
        $stats = [
            'total_ads' => $store->ads()->count(),
            'active_ads' => $store->ads()->where('status', 'active')->count(),
            'featured_ads' => $store->ads()->where('is_featured', true)->count(),
            'total_views' => $store->ads()->sum('views_count') ?? 0,
            'store_views' => $store->views_count ?? 0,
            'pending_ads' => $store->ads()->where('status', 'pending')->count(),
        ];
        
        // Recent store ads
        $recentAds = $store->ads()
            ->with('category', 'images')
            ->latest()
            ->take(10)
            ->get();
        
        return view('vendor.dashboard', compact('store', 'stats', 'recentAds'));
    }
    
    public function analytics()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        // Monthly stats for charts
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $month->format('M'),
                'ads' => $store->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'views' => $store->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('views_count') ?? 0,
            ];
        }
        
        // Top performing ads
        $topAds = $store->ads()
            ->where('status', 'active')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();
        
        // Category breakdown
        $categoryStats = $store->ads()
            ->selectRaw('category_id, count(*) as count')
            ->with('category:id,name')
            ->groupBy('category_id')
            ->get();
        
        return view('vendor.analytics', compact('store', 'monthlyStats', 'topAds', 'categoryStats'));
    }
    
    public function manageAds()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        $ads = $store->ads()
            ->with('category', 'images')
            ->latest()
            ->paginate(20);
        
        return view('vendor.ads-manage', compact('store', 'ads'));
    }
    
    public function storeSettings()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        return view('vendor.store-settings', compact('store'));
    }
    
    public function updateStore(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:stores,name,' . $store->id,
            'description' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'messenger' => 'nullable|string|max:50',
            'facebook' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $validated;
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }
        
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('stores/covers', 'public');
        }
        
        $store->update($data);
        
        return redirect()->route('vendor.store.settings')->with('success', 'تم تحديث إعدادات المتجر بنجاح');
    }
}

```

## 5. مكونات واجهة المستخدم التفاعلية (Livewire)
### Component Logic: app/Livewire/AdCard.php
```php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad;

class AdCard extends Component
{
    // أزلنا النوع "Ad" من هنا لمنع تعارض stdClass
    public $ad; 

    public function mount($ad)
    {
        // نتحقق إذا كان ما وصل هو رقم معرف (ID) أو كائن
        $this->ad = $ad;
    }

    public function render()
    {
        return view('livewire.ad-card');
    }
}
```
### Component Logic: app/Livewire/AdListing.php
```php
<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class AdListing extends Component
{
    use WithPagination;
    public $page = 1;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: null)]
    public $category = null;

    #[Url(except: null)]
    public $minPrice = null;

    #[Url(except: null)]
    public $maxPrice = null;

    #[Url(except: null)]
    public $city = null;

    #[Url(except: null)]
    public $condition = null;

    #[Url(except: 'latest')]
    public $sortBy = 'latest';

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'category', 'minPrice', 'maxPrice', 'city', 'condition', 'sortBy'])) {
            $this->resetPage();
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // 1. بناء الاستعلام الأساسي
        $query = Ad::active()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->category, fn($q) => $q->whereHas('category', fn($sq) => $sq->where('slug', $this->category)))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice))
            ->when($this->city, fn($q) => $q->where('city', $this->city))
            ->when($this->condition, fn($q) => $q->where('condition', $this->condition));

        // 2. الترتيب
        $query = match($this->sortBy) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };

        // 3. جلب البيانات الحقيقية
        $ads = $query->with(['category', 'user', 'images'])->paginate(30);

        // 4. نظام "البيانات الوهمية للملابس" في حال كانت القاعدة فارغة
        if ($ads->isEmpty() && empty($this->search)) {
            $ads = $this->generateFakeClothingAds();
        }

        return view('livewire.ad-listing', [
            'ads' => $ads,
            'categories' => Category::root()->active()->menu()->get(),
        ]);
    }

    /**
     * توليد 30 إعلاناً وهمياً مخصصاً للملابس
     */
    private function generateFakeClothingAds()
    {
        $fakeAds = [];
        $items = [
            ['title' => 'سترة صوفية كلاسيكية', 'price' => 8500],
            ['title' => 'فستان سهرة أسود فاخر', 'price' => 12000],
            ['title' => 'قميص كتان صيفي', 'price' => 4500],
            ['title' => 'بذلة رسمية مودرن', 'price' => 25000],
            ['title' => 'سروال جينز سليم فيت', 'price' => 6200],
            ['title' => 'معطف شتوي ثقيل', 'price' => 18000],
        ];

        for ($i = 1; $i <= 30; $i++) {
            $selection = $items[array_rand($items)];
            $fakeAds[] = (object) [
                'id' => $i,
                'title' => $selection['title'] . " - " . (100 + $i),
                'price' => $selection['price'] + rand(-500, 2000),
                'city' => 'الجزائر العاصمة',
                'condition' => 'new',
                'slug' => 'fake-ad-' . $i,
                'category' => (object) ['name' => 'ملابس', 'slug' => 'clothing'],
                // استخدام صور ملابس حقيقية من Unsplash
                'images' => collect([(object) ['path' => "https://images.unsplash.com/photo-".(1500000000000 + ($i * 1000000))."?auto=format&fit=crop&w=400&q=80"]]),
                'user' => (object) ['name' => 'بوتيك النخبة'],
                'created_at' => now()->subHours($i),
            ];
        }

        // تحويلها إلى Paginator متوافق مع Livewire
        return new LengthAwarePaginator(
            collect($fakeAds)->forPage($this->page, 30),
            count($fakeAds),
            30,
            $this->page
        );
    }
}
```
### Component Logic: app/Livewire/AdSearch.php
```php
<?php

namespace App\Livewire;

use App\Models\Ad;
use Livewire\Component;
use Livewire\WithPagination;

class AdSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $city = '';
    public $category = '';
    
    // لمزامنة البحث مع رابط المتصفح (URL)
    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $ads = Ad::query()
            ->where('status', 'active')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                // ترتيب ذكي: العنوان المطابق يظهر أولاً
                ->orderByRaw("CASE WHEN title LIKE ? THEN 1 ELSE 2 END", ["%{$this->search}%"]);
            })
            ->when($this->city, fn($q) => $q->where('city', $this->city))
            ->latest()
            ->paginate(20);

        return view('livewire.ad-search', [
            'ads' => $ads
        ]);
    }
}
```
### Component Logic: app/Livewire/ContactForm.php
```php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad;
use App\Models\Message;

class ContactForm extends Component
{
    public $adId;
    public $type = 'inquiry';
    public $senderName = '';
    public $senderPhone = '';
    public $senderEmail = '';
    public $message = '';
    public $offerAmount = null;
    public $showForm = false;
    public $success = false;

    protected $rules = [
        'senderName' => 'required|string|max:255',
        'senderPhone' => 'required|string|max:20',
        'senderEmail' => 'nullable|email|max:255',
        'message' => 'required|string|min:10',
        'offerAmount' => 'nullable|numeric|min:0',
    ];

    public function mount($adId, $type = 'inquiry')
    {
        $this->adId = $adId;
        $this->type = $type;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->success = false;
    }

    public function submit()
    {
        $this->validate();

        Message::create([
            'ad_id' => $this->adId,
            'sender_id' => auth()->id(),
            'sender_name' => $this->senderName,
            'sender_phone' => $this->senderPhone,
            'sender_email' => $this->senderEmail,
            'message' => $this->message,
            'type' => $this->type,
            'offer_amount' => $this->offerAmount,
            'status' => 'new',
        ]);

        $this->reset(['senderName', 'senderPhone', 'senderEmail', 'message', 'offerAmount']);
        $this->success = true;
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

```
### Component Logic: app/Livewire/FeaturedAds.php
```php
<?php

namespace App\Livewire;

use Livewire\Component;

class FeaturedAds extends Component
{
    public function render()
    {
        return view('livewire.featured-ads');
    }
}

```
### Component Logic: app/Livewire/Home.php
```php
<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad; // تأكد من استدعاء موديل الإعلانات
use App\Models\FeaturedAd; // إذا كان لديك جدول للمميزة

class Home extends Component
{
    public function render()
    {
        // جلب أحدث 4 إعلانات
        $recentAds = Ad::with('primaryImage')
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        // جلب الإعلانات المميزة
        $featuredAds = FeaturedAd::with('ad.primaryImage')
            ->where('is_active', true)
            ->get();

        return view('livewire.home', [
            'recentAds' => $recentAds,
            'featuredAds' => $featuredAds
        ])->layout('layouts.app'); // تأكيد استخدام الـ Layout الصحيح
    }
}
```
### Component Logic: app/Livewire/NotificationBell.php
```php
<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;
    
    public function mount()
    {
        $this->refreshNotifications();
    }
    
    public function refreshNotifications()
    {
        if (auth()->check()) {
            $this->unreadCount = auth()->user()->unreadNotifications()->count();
            $this->notifications = auth()->user()
                ->notifications()
                ->take(5)
                ->get()
                ->toArray();
        }
    }
    
    public function markAsRead($notificationId)
    {
        if (auth()->check()) {
            $notification = auth()->user()->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->refreshNotifications();
            }
        }
    }
    
    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            $this->refreshNotifications();
        }
    }
    
    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }
    
    public function render()
    {
        return view('livewire.notification-bell');
    }
}

```

## 6. قوالب العرض (Blade Views - Essential)
### Main Layout
```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TRICO | منصة الأزياء العالمية')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Almarai', 'sans-serif'],
                        international: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Almarai', sans-serif; 
            background-color: #0f1115; 
            color: #f3f4f6; 
        }
        .font-heavy { font-weight: 800; }
        .bg-gradient-subtle { 
            background: radial-gradient(circle at top right, #064e3b22 0%, #0f1115 40%); 
        }
        .heavy-title {
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -1px;
        }
        .btn-premium {
            background-color: #10b981;
            color: #000;
            font-weight: 800;
            transition: all 0.3s ease;
            text-transform: uppercase;
            display: inline-block;
            text-align: center;
        }
        .btn-premium:hover {
            background-color: white;
            color: black;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
        }
        
        /* Skeleton Animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    @livewireStyles
</head>
<body class="antialiased min-h-screen bg-gradient-subtle text-white">
    
    @include('components.navbar')

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('components.footer')

    @livewireScripts
</body>
</html>
```
