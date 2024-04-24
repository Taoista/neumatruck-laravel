<div>
   
    <div id="store" class="col-md-12">
        <div class="row">

            @foreach ($productos as $item)
                @livewire("card.card-general", ["id_producto" => $item->id, key($item->id)])
            @endforeach

        </div>
        {{-- {{ $productos->links() }} --}}
    </div>
</div>
