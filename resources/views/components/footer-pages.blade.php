@props(['pages'])

<div class="pt-4 border-t border-gray-700">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
        @foreach($pages as $page)
            <div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ $page['url'] }}" class="text-sm text-dark-400 hover:text-primary-300">
                            {{ $page['title'] }}
                        </a>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
</div>