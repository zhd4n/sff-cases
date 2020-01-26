<?php

namespace App\Models\Parts;

/**
 * App\Models\Parts\CasePart.
 *
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $slug
 * @property string|null $link
 * @property string $description
 * @property mixed $price
 * @property array $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed|null $Column 11
 * @property mixed $formatted_price
 * @property mixed $gallery
 * @property mixed $sorted_properties
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property int|null $media_count
 * @property mixed $upload
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\Part slug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereColumn11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Parts\CasePart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CasePart extends Part
{
    public static $rules = [
        'title'                     => 'required|string',
        'link'                      => 'nullable|url',
        'description'               => 'required|string',
        'price'                     => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'gallery'                   => 'nullable|array',
        'upload'                    => 'nullable|array',
        'upload.*'                  => 'image|mimes:jpeg,gif,png',
        'properties.type'           => 'required|in:mini_itx,micro_atx,atx',
        'properties.size.length'    => 'nullable|integer',
        'properties.size.width'     => 'nullable|integer',
        'properties.size.height'    => 'nullable|integer',
        'properties.size.volume'    => 'nullable|numeric',
        'properties.size.footprint' => 'nullable|integer',
        'properties.storage.hdd'    => 'nullable|integer',
        'properties.storage.ssd'    => 'nullable|integer',
        'properties.psu.type'       => 'required',
        'properties.psu.type.*'     => 'in:atx,sfx,sfx_l,flex_atx,dc_atx',
        'properties.psu.max_length' => 'nullable|integer',
        'properties.gpu.max_length' => 'nullable|integer',
        'properties.gpu.slots'      => 'nullable|string',
        'properties.cpu.max_height' => 'nullable|integer',
        'properties.fans.top'       => 'nullable|string',
        'properties.fans.front'     => 'nullable|string',
        'properties.fans.bottom'    => 'nullable|string',
        'properties.fans.rear'      => 'nullable|string',
        'properties.fans.side'      => 'nullable|string',
        'properties.radiator'       => 'nullable|string',
        'properties.slots'          => 'nullable|string',
    ];

    protected $attributes = [
        'type'       => 'case',
        'properties' => [
            'type' => 'n/a',
            'size' => [
                'length'    => 'n/a',
                'width'     => 'n/a',
                'height'    => 'n/a',
                'volume'    => 'n/a',
                'footprint' => 'n/a',
            ],
            'storage' => [
                'HDD' => 'n/a',
                'SSD' => 'n/a',
            ],
            'psu' => [
                'type'       => 'n/a',
                'max_length' => 'n/a',
            ],
            'gpu' => [
                'max_length' => 'n/a',
            ],
            'slots' => 'n/a',
            'cpu'   => [
                'cooler_max_height' => 'n/a',
            ],
            'fans' => [
                'top'    => 'n/a',
                'front'  => 'n/a',
                'bottom' => 'n/a',
                'rear'   => 'n/a',
                'side'   => 'n/a',
            ],
            'radiator' => 'n/a',
        ],
    ];

    public $propertiesOrder = [
        'type',
        'size',
        'psu',
        'cpu',
        'gpu',
        'storage',
        'fans',
        'radiator',
        'slots',
    ];
}
