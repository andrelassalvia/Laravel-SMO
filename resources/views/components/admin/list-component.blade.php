{{-- Table to list collection --}}
<div>
    <table class="table table-striped table-hover mb-3" style="width: 80%; margin:auto">
        <tr>
            <th>{{$column}}</th>
            <th width='100'>Ações</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{$item->nome}}</td>
                <td width='100'>
                    <a href="{{route($tableName().'.edit',$item->id)}}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pen" aria-hidden="true"></i>
                    </a>
                    <a href="{{route($tableName().'.show', $item->id)}}" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</div>