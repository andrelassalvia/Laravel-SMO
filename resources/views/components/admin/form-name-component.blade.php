{{-- Base form to create, edit and show a register  --}}
<div class="form2">
    <form 
        action="{{route($routeModel(), $info())}}" 
        method="post"
        >
        {{$tabs}}
        <div class="form5">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            {{$delete}}
            <div class="row mb-2">
                <label 
                    for="nome" 
                    class="col-sm-2 col-form-label">{{$modelUpper()}}:
                </label>
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
    {{$form2}}
    {{$button}}
    {{$form3}}
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