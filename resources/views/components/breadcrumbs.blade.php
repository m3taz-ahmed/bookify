@props(['pages'])

<nav aria-label="Breadcrumb" class="mb-6">
    <ol class="flex items-center space-x-2 text-sm">
        <li>
            <a href="{{ route('booking-welcome') }}" class="text-blue-600 hover:text-blue-800">
                {{ __('website.Home') }}
            </a>
        </li>
        
        @foreach($pages as $page)
            <li class="flex items-center">
                <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                @if(isset($page['url']))
                    <a href="{{ $page['url'] }}" class="text-blue-600 hover:text-blue-800">
                        {{ $page['title'] }}
                    </a>
                @else
                    <span class="text-gray-500">
                        {{ $page['title'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>