<div>
    <div id="aside" class="col-md-3">
        <div class="aside">
            <h3 class="aside-title">Marcas</h3>
            <div class="checkbox-filter">
                {{-- ? filtro normal --}}
                <div class="normal-checkboxes">
                    @foreach($brands as $item)
                        <div class="input-checkbox">
                            <input type="checkbox" name="filtro_marca" value="{{ $item->id_marca }}" wire:model="list_brands">
                            <label for="{{ $item->id_marca }}">{{ strtoupper($item->marca) }}</label>
                        </div>
                    @endforeach
                </div>
                {{-- ? filtro responsive --}}
                <div class="responsive-select">
                {{-- <div class=""> --}}
                    <select id="id_brands" wire:change="add_key_search" wire:model="id_brands_select">
                        <option value="0">Seleccione una marca</option>
                        @foreach($brands as $item)
                            <option value="{{ $item->id_marca }}">{{ strtoupper($item->marca) }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>
            <h3 class="aside-title">Medidas</h3>
            <div class="normal-checkboxes">
                <input type="text" wire:model="filter_key">
                <button>X</button>
            </div>
            <div class="checkbox-filter normal-checkboxes">
                <br>
                @foreach($sizes AS $item)
                <div class="input-checkbox">
                    <input type="checkbox" name="filtro_marca" value="{{ $item->medidas }}" wire:model="list_sizes">
                    <label for="{{ $item->medidas }}">{{ $item->medidas }}</label>
                </div>
                @endforeach
            </div>
            {{-- ? --}}
            <div class="responsive-select">
                <select id="id_brands" wire:change="add_key_search_size" wire:model="id_sizes_select">
                    <option value="0">Seleccione una medida</option>
                    @foreach($sizes as $item)
                        <option value="{{ $item->medidas }}">{{ $item->medidas }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div id="store" class="col-md-9">
        <div class="row">
            {{-- @livewire("card.card-general", ["id_producto" => 7, key(7)]) --}}

            @foreach ($productos as $item)
            {{-- {{ $item->id.' -> '.$item->marca.' -> '.$item->nombre.' -> '.$item->id_marca }} <br> --}}
                @livewire("card.card-general", ["id_producto" => $item->id, key($item->id)])
            @endforeach

        </div>
        {{ $productos->links() }}
    </div>
</div>
