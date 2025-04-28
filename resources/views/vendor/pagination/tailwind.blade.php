@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="mt-6 flex justify-center">
        <ul class="flex space-x-2">
            {{-- Tombol First & Previous --}}
            <li>
                <a href="{{ $paginator->url(1) }}" class="w-10 h-10 flex items-center justify-center text-gray-500 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                    «
                </a>
            </li>
            @if ($paginator->onFirstPage())
                <li class="w-10 h-10 flex items-center justify-center text-gray-400 bg-gray-200 rounded-full cursor-not-allowed">
                    ‹
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center text-gray-500 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                        ‹
                    </a>
                </li>
            @endif

            {{-- Hitung range halaman yang akan ditampilkan --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            {{-- Tampilkan "..." jika bukan di halaman awal --}}
            @if ($start > 1)
                <li class="w-10 h-10 flex items-center justify-center text-gray-500">...</li>
            @endif

            {{-- Nomor Halaman --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="w-10 h-10 flex items-center justify-center font-semibold text-white bg-blue-500 rounded-full shadow-md">
                        {{ $page }}
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($page) }}" class="w-10 h-10 flex items-center justify-center text-gray-700 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endfor

            {{-- Tampilkan "..." jika bukan di halaman akhir --}}
            @if ($end < $lastPage)
                <li class="w-10 h-10 flex items-center justify-center text-gray-500">...</li>
            @endif

            {{-- Tombol Next & Last --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center text-gray-500 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                        ›
                    </a>
                </li>
            @else
                <li class="w-10 h-10 flex items-center justify-center text-gray-400 bg-gray-200 rounded-full cursor-not-allowed">
                    ›
                </li>
            @endif
            <li>
                <a href="{{ $paginator->url($lastPage) }}" class="w-10 h-10 flex items-center justify-center text-gray-500 bg-gray-200 rounded-full hover:bg-gray-300 transition">
                    »
                </a>
            </li>
        </ul>
    </nav>
@endif
