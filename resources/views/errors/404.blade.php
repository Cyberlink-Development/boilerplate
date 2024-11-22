@extends('admin.common.master')

@section('page_sub_title')
    ~ 404 Not Found
@endsection

@section('content')
    <div class="flex justify-center items-center h-screen m-0 bg-gray-200 text-gray-800">
        <div class="max-w-4xl p-8 bg-white border border-gray-300 rounded-lg shadow-lg text-center">
            <h1 class="text-6xl font-bold text-red-600">404</h1>
            <p class="text-2xl mt-6 mb-5 text-gray-800">Oops! The page you’re looking for doesn’t exist.</p>
            <p class="text-lg text-gray-600">
                It might have been moved or deleted. You can return to the<br>
                <a href="/admins" class="text-blue-500 font-bold hover:underline">admin page</a> or
                <a href="/login" class="text-blue-500 font-bold hover:underline">user page</a>.
            </p>
        </div>
    </div>
@endsection

