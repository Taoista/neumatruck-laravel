<div>
    <div id="aside" class="col-md-3">
        <div class="aside">
            <h3 class="aside-title">Marcas</h3>
            <div class="checkbox-filter">


                @for ($i=0; $i < count($list_brands); $i++)
                <div class="input-checkbox">
                    <input type="checkbox" name="filtro_marca" value="{{ $list_brands[$i]["id_marca"] }}" wire:model="imputs_brands">
                    <label for="{{ $list_brands[$i]["id_marca"] }}">{{ strtoupper($list_brands[$i]["marca"]) }}</label>
                </div>
                @endfor

            </div>
            <h3 class="aside-title">Medidas</h3>
            <input type="text" wire:model="filter_key">
            <button>X</button>
            <div class="checkbox-filter">
                <br>

                @for ($i=0; $i < count($list_sizes); $i++)
                <div class="input-checkbox">
                    <input type="checkbox" name="filtro_marca" value="{{ $list_sizes[$i] }}" wire:model="imputs_sizes">
                    <label for="{{ $list_sizes[$i] }}">{{ $list_sizes[$i] }}</label>
                </div>
                @endfor
            </div>
        </div>
    </div>
    <div id="store" class="col-md-9">
        <div class="row">

            @foreach ($productos as $item)
                @if($controller->state_oferta($item->id) == true)
                    @livewire("card.card-general", ["id_producto" => $item->id, key($item->id)])
                @endif
            @endforeach

        </div>
        {{-- {{ $productos->links() }} --}}
    </div>
</div>
