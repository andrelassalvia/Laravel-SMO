{{-- Form to search in database --}}
<div>
    <form 
      method="get" 
      class="input-group" 
      action="{{route($table.'.search')}}"
      >
      <input 
      type="text" 
      class="form-control" 
      name="nome" 
      placeholder="{{$placeholder}}" 
      >
      <button class="btn btn-primary">
        <i class="bi bi-search" aria-hidden="true"></i>
      </button>
    </form>
</div>