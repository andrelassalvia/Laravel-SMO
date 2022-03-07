<div class="form-search" style="margin-bottom: 20px; margin-left:10%; 100px;width:20%">
    <form method="get" class="search" action="{{route($table.'.search')}}">
      <input type="text" class="form-control me-2" name="{{$name}}" placeholder="{{$placeholder}}" >
      <button class="btn btn-primary">
        <i class="bi bi-search" aria-hidden="true"></i>
      </button>
    </form>
</div>