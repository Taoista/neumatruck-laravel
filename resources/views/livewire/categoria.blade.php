<div>
    <div id="aside" class="col-md-3">
        <div class="aside">
            <h3 class="aside-title">Marcas</h3>
            <div class="checkbox-filter normal-checkboxes">
                @foreach($list_brands AS $item)
                <div class="input-checkbox">
                    <input type="checkbox" name="filtro_marca" value="{{ $item->id_marca }}" wire:model="imputs_brands">
                    <label for="{{ $item->id_marca }}">{{ strtoupper($item->marca) }}</label>
                </div>
                @endforeach
            </div>
            {{-- ? filtro responsive --}}
            <div class="responsive-select ">
                {{-- <div class=""> --}}
                    <select id="id_brands" wire:change="add_key_search" wire:model="id_brands_select">
                        <option value="0">Seleccione una marca</option>
                        @foreach($list_brands as $item)
                            <option value="{{ $item->id_marca }}">{{ strtoupper($item->marca) }}</option>
                        @endforeach
                    </select>
                </div>
            <h3 class="aside-title">Medidas</h3>
            <div class="normal-checkboxes">
                <input type="text" wire:model="filter_key">
                <button>X</button>
            </div>
            
            <div class="checkbox-filter">
                <br>
                @foreach($list_sizes AS $item)
                <div class="input-checkbox normal-checkboxes">
                    <input type="checkbox" name="filtro_marca" value="{{ $item->medidas }}" wire:model="imputs_sizes">
                    <label for="{{ $item->medidas }}">{{ $item->medidas }}</label>
                </div>
                @endforeach
            </div>
            {{-- ? sizes responsive --}}
            <div class="responsive-select">
                <select id="id_brands" wire:change="add_key_search_size" wire:model="id_sizes_select">
                    <option value="0">Seleccione una medida</option>
                    @foreach($list_sizes as $item)
                        <option value="{{ $item->medidas }}">{{ $item->medidas }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div id="store" class="col-md-9">
        <div class="row">

            @foreach ($productos as $item)
                @livewire("card.card-general", ["id_producto" => $item->id, key($item->id)])
            @endforeach

        </div>
        {{ $productos->links() }}
    </div>
</div>
