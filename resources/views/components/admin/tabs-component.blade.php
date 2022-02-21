{{-- create tabs into a form --}}
<div >
    <li class="nav-item">
        <a 
            class="nav-link tab--nav {{$active}}" 
            aria-current="page" 
            href="{{route($route, [$id])}}">
            {{$tabName}}
        </a>
    </li>
</div>