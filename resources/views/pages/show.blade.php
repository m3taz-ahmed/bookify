@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-background-50 to-accent-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500 rounded-full -mt-16 -mr-16 opacity-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary-500 rounded-full -mb-12 -ml-12 opacity-10"></div>
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }}</h1>
                </div>
            </div>
            
            <div class="px-6 py-8">
                <div class="prose prose-lg max-w-none">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection