<div>
    {{$info}}
    <form action="{{route($routeModel(), $info())}}" class="form-control form--create" method="post">
        {{$tabs}}
        <div class="form1">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            {{$delete}}
            {{$form}}
            {{$button}}
        </div>
    </form>
</div>