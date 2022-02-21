{{-- Base form to create, edit and show a register  --}}
<div>
    <form action="{{route($routeModel(), $info())}}" class="form-control form--create" method="post">
        {{$tabs}}
        <div class="form1">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            {{$delete}}
            <div class="d-flex">
            <div class="form-group d-flex col-sm-11">
                <label for="nome" class="control-label col-sm-2 control-label--create">{{$modelUpper()}}:</label>
                <div class=" col-sm-8">
                    <input 
                        placeholder="{{"Cadastrar $modelUpper"}}" 
                        type="text" name="nome" 
                        class="form-control" 
                        value="{{$value()}}" 
                        {{$able()}}>
                </div>
            </div>
        </div>
    </div>
    {{$form2}}
    {{$form3}}
    {{$button}}
    </form>
</div>

{{-- 
    SLOTS
        tabs
        delete
        form2
        form3
        button
 --}}