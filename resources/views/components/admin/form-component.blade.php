<div class="form3">
  <div class="row mb-2">
    <label class="col-sm-2 col-form-label" for="{{$optionColumn}}">{{$label}}</label>
    <div class="col-sm-8">
        <select class="form-select" name="{{$optionColumn}}">
          <option value="">Selecione</option>
              @foreach ($data as $dt)
              <option 
                value="{{$dt->id}}" 
                {{old($optionColumn) == $dt->id ? 'selected' : '' }}
                >{{$dt->nome}}
              </option>
              @endforeach
          </select>
    </div>    
  </div>
</div> 