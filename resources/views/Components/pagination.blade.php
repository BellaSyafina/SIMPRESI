<div class="p-3 border-top">

    <div class="d-flex flex-column flex-md-row
        justify-content-between align-items-center gap-3">

        {{-- INFO --}}
        <small class="text-white">
            Showing {{ $data->firstItem() ?? 0 }}
            to {{ $data->lastItem() ?? 0 }}
            of {{ $data->total() }} results
        </small>

        {{-- PAGINATION --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">

            {{-- PREVIOUS --}}
            @if ($data->onFirstPage())
                <button class="btn btn-sm btn-outline-secondary" disabled>
                    &laquo; Previous
                </button>
            @else
                <a href="{{ $data->previousPageUrl() }}" class="btn btn-sm btn-outline-light">
                    &laquo; Previous
                </a>
            @endif

            {{-- PAGE NUMBER --}}
            @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                @if ($page == $data->currentPage())
                    <span class="btn btn-sm btn-primary">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="btn btn-sm btn-outline-light">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- NEXT --}}
            @if ($data->hasMorePages())
                <a href="{{ $data->nextPageUrl() }}" class="btn btn-sm btn-outline-light">
                    Next &raquo;
                </a>
            @else
                <button class="btn btn-sm btn-outline-secondary" disabled>
                    Next &raquo;
                </button>
            @endif

        </div>

    </div>

</div>
