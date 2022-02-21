<div class="pagination">
  @if(isset($dataForm))
    {{$data->appends($dataForm)->links()}}
  @else
    {{$data->links()}}
  @endif
</div>