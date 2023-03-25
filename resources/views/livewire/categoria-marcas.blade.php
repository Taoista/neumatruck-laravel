<div>
    <div id="aside" class="col-md-3">
        <div class="aside">
            <h3 class="aside-title">Marcas</h3>
            <div class="checkbox-filter">
                @foreach($list_brands AS $item)
                <div class="input-checkbox">
                    <input type="checkbox" name="filtro_marca" value="{{ $item->id_marca }}" checked disabled>
                    <label for="{{ $item->id_marca }}">{{ strtoupper($item->marca) }}</label>
                </div>
                @endforeach
            </div>
            <h3 class="aside-title">Medidas</h3>
            <input type="text" wire:model="filter_key">
            <button>X</button>
            <div class="checkbox-filter">
                <br>
                @foreach($list_sizes AS $item)
                <div class="input-checkbox">
                    <input type="checkbox" name="filtro_marca" value="{{ $item->medidas }}" wire:model="imputs_sizes">
                    <label for="{{ $item->medidas }}">{{ $item->medidas }}</label>
                </div>
                @endforeach
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
