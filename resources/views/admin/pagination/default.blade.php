@if($paginator->hasPages())
<style>
    .page-section {
        display: flex;
        justify-content: right;
        width: 100%;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0 25px 25px 25px;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-item .page-link {
        color: #fff;
        background-color: #191c24;
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 8px 12px;
        text-align: center;
        font-size: 16px;
        transition: all 0.2s ease-in-out;
    }

    .page-item .page-link:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .page-item.disabled .page-link {
        background-color: #6c757d;
        border-color: #6c757d;
        color: #d1d1d1;
        cursor: not-allowed;
    }

    .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }
</style>
<nav class="page-section">
    <ul class="pagination">
        @if($paginator->onFirstPage())
        <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{$paginator->previousPageUrl()}}" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        @endif
        @foreach ($elements as $element)
        @if(is_string($element))
        <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0)">{{$element}}</a>
        </li>
        @endif

        @if(is_array($element))
        @foreach ($element as $page => $url)
        @if($page == $paginator->currentPage())
        <li class="page-item active">
            <a class="page-link" href="javascript:void(0)">{{$page}}</a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{$url}}">{{$page}}</a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        @if($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{$paginator->nextPageUrl()}}" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
        @else
        <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0)" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
        @endif
    </ul>
</nav>
@endif