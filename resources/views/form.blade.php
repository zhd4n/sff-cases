@extends('layouts.main')

@section('content')
    <form action="{{ isset($case) ? route('cases.update', $case) : route('cases.store') }}"
          method="POST" enctype="multipart/form-data"
          class="ui form @if($errors->any()) error @endif">
        @csrf
        @isset($case)
            @method('PUT')
        @endisset
        <div class="ui error message">
            <div class="header">Validation error</div>
            <div class="ui list">
            @foreach ($errors->all() as $error)
                <div class="item">{{ $error }}</div>
            @endforeach
            </div>
        </div>
        <div class="ui segments">
            <h1 class="ui attached top header">
                @isset($case)
                    Edit Case #{{ $case->id }}
                @else
                    Add Case
                @endisset

                @isset($case)
                    <a class="ajax-delete ui negative right floated button" href="{{ route('cases.delete', $case, false) }}">
                        <i class="trash icon"></i>Delete
                    </a>
                @endisset

                <button class="ui positive right floated button" type="submit">
                    <i class="save icon"></i> Save
                </button>
            </h1>
            <div class="ui basic segment">
                <h4 class="ui header">Photos</h4>
                <div class="field">
                    <label for="images" class="ui icon button">
                        <i class="file icon"></i>
                        Choose files
                    </label>
                    <input type="file" id="images" name="images[]" multiple="multiple" accept="image/png, image/jpeg, image/gif" class="ui file input">
                </div>
                @isset($case)
                    <div class="ui cards">
                    @foreach ($case->getMedia('gallery') as $photo)
                        <div class="ui card">
                            <div class="image">
                                <img class="image" src="{{ $photo->getUrl() }}">
                            </div>
                            <div class="extra content">
                            <a href="{{ route('cases.media.delete', ['case_part' => $case, 'media' => $photo]) }}" class="ui ajax-delete fluid bottom button">
                                <i class="trash icon"></i>
                                Delete
                            </a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endisset
            </div>

            <div class="ui secondary basic segment">
                <h4 class="ui header">Common information</h4>
                <div class="ui grid">
                    <div class="ui fourteen wide column">
                        <div class="fields">
                            <div class="eight wide field @error('title') error @enderror">
                                <label>Title</label>
                                <input type="text" name="title" value="{{ $case->title ?? old('title') }}" required placeholder="Product name">

                            </div>
                            <div class="five wide field @error('link') error @enderror">
                                <label>Link</label>
                                <input type="text" name="link" value="{{ $case->link ?? old('link') }}" placeholder="Link to product">
                            </div>
                            <div class="three wide field @error('price') error @enderror">
                                <label>Price</label>
                                <input type="text" name="price" value="{{ $case->price ?? old('price') }}" required placeholder="Price, 199.99">
                            </div>
                        </div>
                        <div class="field @error('description') error @enderror">
                            <label>Description</label>
                            <textarea rows="5" name="description" required
                                      placeholder="Some notes about the case">{{ $case->description ?? old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="ui two wide column">
                        <div class="grouped fields">
                            <label for="fruit">Type:</label>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="properties[type]" value="mini_itx" @if(($case->properties['type'] ?? old('properties.type'))=== 'mini_itx' || ! old('properties.type')) checked="" @endif class="hidden">
                                    <label>Mini-ITX</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="properties[type]" value="micro_atx" @if(($case->properties['type'] ?? old('properties.type')) === 'micro_atx') checked="" @endif class="hidden">
                                    <label>Micro-ATX</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="properties[type]" value="atx" @if(($case->properties['type'] ?? old('properties.type')) === 'atx')) checked="" @endif class="hidden">
                                    <label>ATX</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui basic segment">
                <h4 class="ui header">Size</h4>
                <div class="equal width fields">
                    <div class="field @error('properties.size.length') error @enderror">
                        <label>Length</label>
                        <input type="number" name="properties[size][length]" value="{{ $case->properties['size']['length'] ?? old('properties.size.length') }}" min="0" placeholder="Length, mm">
                    </div>
                    <div class="field @error('properties.size.width') error @enderror">
                        <label>Width</label>
                        <input type="number" name="properties[size][width]" value="{{ $case->properties['size']['width']?? old('properties.size.width') }}" min="0" placeholder="Width, mm">
                    </div>
                    <div class="field @error('properties.size.height.') error @enderror">
                        <label>Height</label>
                        <input type="number" name="properties[size][height]" value="{{ $case->properties['size']['height'] ?? old('properties.size.height') }}" min="0" placeholder="Height, mm">
                    </div>
                    <div class="field @error('properties.size.footprint') error @enderror">
                        <label>Footprint</label>
                        <input type="text" name="properties[size][footprint]" value="{{ $case->properties['size']['footprint'] ?? old('properties.size.footprint') }}" min="0" placeholder="Footprint">
                    </div>
                    <div class="field  @error('properties.size.volume') error @enderror">
                        <label>Volume</label>
                        <input type="number" name="properties[size][volume]" value="{{ $case->properties['size']['volume'] ?? old('properties.size.volume') }}" min="0" placeholder="Volume, l">
                    </div>
                </div>
            </div>

            <div class="ui secondary basic segment">
                <h4 class="ui header">CPU</h4>
                <div class="field @error('properties.cpu.max_height') error @enderror">
                    <label>CPU cooler max height</label>
                    <input type="number" name="properties[cpu][max_height]" value="{{ $case->properties['cpu']['max_height'] ?? old('properties.cpu.max_length') }}" placeholder="mm">
                </div>
            </div>

            <div class="ui basic segment">
                <h4 class="ui header">GPU</h4>
                <div class="field @error('properties.gpu.max_length') error @enderror">
                    <label>Max length</label>
                    <input type="number" name="properties[gpu][max_length]" value="{{ $case->properties['gpu']['max_length'] ?? old('properties.gpu.max_length') }}" placeholder="mm">
                </div>
            </div>

            <div class="ui secondary basic segment">
                <h4 class="ui header">PSU</h4>
                <div class="ui grid">
                    <div class="eight wide column">
                        <div class="grouped fields @error('properties.psu.type') error @enderror">
                            <label>Type</label>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="properties[psu][type][]" value="atx" @if(in_array('atx', $case->properties['psu']['type'] ?? old('properties.psu.type', []))) checked @endif class="hidden">
                                    <label for="properties[psu][atx]">ATX</label>
                                </div>
                            </div>

                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="properties[psu][type][]" value="sfx" @if(in_array('sfx', $case->properties['psu']['type'] ?? old('properties.psu.type', []))) checked @endif class="hidden">
                                    <label for="properties[psu][sfx]">SFX</label>
                                </div>
                            </div>

                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="properties[psu][type][]" value="sfx_l" @if(in_array('sfx_l', $case->properties['psu']['type'] ?? old('properties.psu.type', []))) checked @endif class="hidden">
                                    <label for="properties[psu][sfx_l]">SFX-L</label>
                                </div>
                            </div>

                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="properties[psu][type][]" value="flex_atx" @if(in_array('flex_atx', $case->properties['psu']['type'] ?? old('properties.psu.type', []))) checked @endif class="hidden">
                                    <label for="properties[psu][flex_atx]">FlexATX</label>
                                </div>
                            </div>

                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" name="properties[psu][type][]" value="dc_atx" @if(in_array('dc_atx', $case->properties['psu']['type'] ?? old('properties.psu.type', []))) checked @endif class="hidden">
                                    <label for="properties[psu][dc_atx]">DC-ATX Pico</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="eight wide column">
                        <div class="field @error('properties.psu.max_length') error @enderror">
                            <label>Max length</label>
                            <input type="number" name="properties[psu][max_length]" value="{{ $case->properties['psu']['max_length'] ?? old('properties.psu.max_length') }}" placeholder="mm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui basic segment">
                <h4 class="ui header">Storage</h4>
                <div class="two fields">
                    <div class="field @error('properties.storage.hdd') error @enderror">
                        <label>HDD 3.5</label>
                        <input type="number" name="properties[storage][hdd]" value="{{ $case->properties['storage']['hdd'] ?? old('properties.storage.hdd') }}" placeholder="Supported HDD count">
                    </div>
                    <div class="field @error('properties.storage.ssd') error @enderror">
                        <label for="">SSD 2.5</label>
                        <input type="number" name="properties[storage][ssd]" value="{{ $case->properties['storage']['ssd'] ?? old('properties.storage.ssd') }}" placeholder="Supported SSD count">
                    </div>
                </div>
            </div>

            <div class="ui secondary basic segment">
            <h4 class="ui header">Supported fans</h4>
                <div class="equal width fields">
                    <div class="field @error('properties.fans.') error @enderror">
                        <label>Front</label>
                        <input type="text" name="properties[fans][front]" value="{{ $case->properties['fans']['front'] ?? old('properties.fans.front') }}" placeholder="">
                    </div>
                    <div class="field @error('properties.fans.') error @enderror">
                        <label>Top</label>
                        <input type="text" name="properties[fans][top]" value="{{ $case->properties['fans']['top'] ?? old('properties.fans.top') }}" placeholder="">
                    </div>
                    <div class="field @error('properties.fans.') error @enderror">
                        <label>Bottom</label>
                        <input type="text" name="properties[fans][bottom]" value="{{ $case->properties['fans']['bottom'] ?? old('properties.fans.bottom') }}" placeholder="">
                    </div>
                    <div class="field @error('properties.fans.') error @enderror">
                        <label>Rear</label>
                        <input type="text" name="properties[fans][rear]" value="{{ $case->properties['fans']['rear'] ?? old('properties.fans.rear') }}" placeholder="">
                    </div>
                    <div class="field @error('properties.fans.') error @enderror">
                        <label>Side</label>
                        <input type="text" name="properties[fans][side]" value="{{ $case->properties['fans']['side'] ?? old('properties.fans.side') }}" placeholder="">
                    </div>
                </div>
            </div>
            <div class="ui basic segment right aligned">
                <button class="ui positive button" type="submit">
                   <i class="save icon"></i> Save
                </button>
            </div>
        </div>
    </form>
@endsection
