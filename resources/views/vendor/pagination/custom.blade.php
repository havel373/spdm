@if ($paginator->hasPages())
    <nav class="mt-5 flex justify-center">
        <ul class="pagination border flex rounded-lg items-center w-fit">
            @if ($paginator->onFirstPage())
                <li class="px-4 py-0 opacity-30 disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link text-3xl" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="px-4 py-0">
                    <a class="page-link text-3xl text-green-400" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="px-4 py-2 disabled" aria-disabled="true"><span class="page-link text-lg">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-4 py-2 text-white bg-gradient-to-br from-green-custom transition-all duration-300 to-blue-custom active" aria-current="page"><span class="page-link text-lg">{{ $page }}</span></li>
                        @else
                            <li class="px-4 py-2 text-green-400"><a class="page-link text-lg" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif  
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="px-4 py-0">
                    <a class="page-link text-3xl text-green-400" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="px-4 py-0 disabled opacity-30" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link text-3xl" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif