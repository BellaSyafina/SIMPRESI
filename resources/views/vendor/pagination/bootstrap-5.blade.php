@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-between align-items-center flex-wrap gap-2 mb-0">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link rounded-pill px-3">
                        &laquo; Previous
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill px-3"
                        href="{{ $paginator->previousPageUrl() }}">
                        &laquo; Previous
                    </a>
                </li>
            @endif

            {{-- Pages --}}
            <div class="d-flex gap-1">
                @foreach ($elements as $element)

                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link rounded-pill">
                                {{ $element }}
                            </span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <span class="page-link rounded-pill">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link rounded-pill"
                                        href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill px-3"
                        href="{{ $paginator->nextPageUrl() }}">
                        Next &raquo;
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link rounded-pill px-3">
                        Next &raquo;
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
