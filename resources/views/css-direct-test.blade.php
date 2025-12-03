@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-600">Direct CSS Test</h1>
    <p class="text-gray-700">If you see styled text, CSS is working correctly.</p>
    
    <div class="card-hover mt-4 p-4 bg-white rounded shadow">
        <p>This should have hover effects if CSS is loading correctly.</p>
    </div>
    
    <button class="btn-primary mt-4">Primary Button</button>
    <button class="btn-secondary mt-4">Secondary Button</button>
    
    <div class="mt-8">
        <h2 class="text-2xl font-bold">Tailwind Classes Test</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div class="bg-red-100 p-4 rounded">Red Background</div>
            <div class="bg-green-100 p-4 rounded">Green Background</div>
            <div class="bg-blue-100 p-4 rounded">Blue Background</div>
        </div>
    </div>
</div>
@endsection