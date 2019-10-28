<?php

namespace App\Models\Parts;

use App\Scopes\PartTypeScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Parts\Part.
 *
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part slug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part type($type)
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $price
 * @property array $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereUpdatedAt($value)
 * @property string|null $link
 * @property mixed $formatted_price
 * @property mixed $gallery
 * @property mixed $sorted_properties
 * @property mixed $upload
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part whereLink($value)
 */
class Part extends Model implements HasMedia
{
    use HasMediaTrait;
    use HasSlug;

    protected $table = 'parts';

    protected $fillable = [
        'title',
        'slug',
        'link',
        'price',
        'description',
        'properties',
        'gallery',
        'upload',
    ];

    protected $casts = [
        'type'       => 'string',
        'title'      => 'string',
        'slug'       => 'string',
        'price'      => 'decimal:2',
        'properties' => 'array',
    ];

    protected $appends = [
        'formatted_price',
        'gallery',
    ];

    public $propertiesOrder = [];

    protected static function boot()
    {
        parent::boot();

        if (class_basename(static::class) !== 'Part') {
            self::addGlobalScope(new PartTypeScope(static::getPartType()));
        }
    }

    public function getSlugOptions()
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public static function getPartType()
    {
        return strtolower(str_replace('Part', '', class_basename(static::class)));
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $className = Str::ucfirst(data_get((array) $attributes, 'type'));
        $className = "App\\Models\\Parts\\{$className}Part";

        if (class_exists($className)
            && is_subclass_of($className, self::class)
        ) {
            $model = (new $className())->newInstance([], true);
        } else {
            $model = $this->newInstance([], true);
        }

        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('small')
            ->keepOriginalImageFormat()
            ->quality(100)
            ->sharpen(10)
            ->fit(Manipulations::FIT_FILL, 60, 60)
            ->border(4, '#ffffff', Manipulations::BORDER_EXPAND)
            ->background('transparent');

        $this->addMediaConversion('medium')
            ->keepOriginalImageFormat()
            ->quality(100)
            ->sharpen(10)
            ->fit(Manipulations::FIT_FILL, 205, 205)
            ->border(20, '#ffffff', Manipulations::BORDER_EXPAND)
            ->background('transparent');

        $this->addMediaConversion('large')
            ->keepOriginalImageFormat()
            ->quality(100)
            ->sharpen(10)
            ->fit(Manipulations::FIT_FILL, 310, 310)
            ->border(20, '#ffffff', Manipulations::BORDER_EXPAND)
            ->background('transparent');

        $this->addMediaConversion('full')
            ->keepOriginalImageFormat()
            ->quality(100)
            ->sharpen(10)
            ->fit(Manipulations::FIT_FILL, 780, 580)
            ->border(20, '#ffffff', Manipulations::BORDER_EXPAND)
            ->background('transparent');
    }

    public function getRouteKeyName(): string
    {
        if (in_array(request()->route()->methods()[0], ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return 'id';
        }

        return 'slug';
    }

    public function getFormattedPriceAttribute()
    {
        $price = explode('.', $this->attributes['price']);

        if ($price[1] === '00') {
            return $price[0];
        }

        return $this->attributes['price'];
    }

    public function getSortedPropertiesAttribute()
    {
        $order = array_flip($this->propertiesOrder);

        return collect($this->properties)->sortBy(function ($prop, $key) use ($order) {
            return $order[$key] ?? 100;
        })->toArray();
    }

    public function scopeSlug(Builder $query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    public function fromJson($value, $asObject = false)
    {
        return is_array($value) ? $value : json_decode($value, ! $asObject);
    }

    public function getGalleryAttribute()
    {
        if (! $this->relationLoaded('media')) {
            return null;
        }

        $items = [];

        /**
         * @var Media $item
         */
        foreach ($this->getMedia() as $item) {
            $items[] = [
                'id'   => $item->id,
                'name' => $item->name,
                'url'  => $item->getUrl(),
            ];
        }

        return $items;
    }

    public function setGalleryAttribute($value)
    {
        $gallery = $this->getMedia();

        //Sync gallery
        $newGallery = collect($value ?? []);

        $gallery->each(function ($photo) use ($newGallery) {
            if (! $newGallery->firstWhere('id', $photo['id'])) {
                $this->deleteMedia($photo['id']);
            }
        });
    }

    public function setUploadAttribute($value)
    {
        foreach ($value as $file) {
            //TODO generate name from slug
            $this->addMedia($file)->toMediaCollection();
        }
    }
}
