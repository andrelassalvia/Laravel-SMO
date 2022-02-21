<div class="form1">
  
    <div class="form-group d-flex col-sm-11">
      <label class="control-label col-sm-2 control-label--create" for="{{$optionColumn}}">{{$label}}</label>
      <div class="col-sm-8">
        <select class="form-select" name="{{$optionColumn}}">
          <option value="">Selecione</option>
              @foreach ($data as $dt)
              <option value="{{$dt->id}}" {{old($optionColumn) == $dt->id ? 'selected' : '' }}>{{$dt->nome}}</option>
              @endforeach
            </select>
        </div>  
      </div>
</div>