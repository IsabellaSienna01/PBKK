@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <section class="mx-auto flex min-h-[calc(100vh-185px)] max-w-6xl items-center px-6 py-16 lg:px-8">
        <div class="max-w-2xl border-l-4 border-blue-600 pl-6 sm:pl-8">
            <p class="text-7xl font-semibold tracking-tighter text-slate-200 sm:text-8xl">404</p>
            <p class="mt-6 text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Page Not Found</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">This page is not part of the academic profile.</h1>
            <p class="mt-5 max-w-xl text-lg leading-8 text-slate-600">The page you're looking for doesn't exist or the URL may be incorrect.</p>

            <a href="{{ route('home') }}" class="mt-8 inline-flex rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                Back to Home
            </a>
        </div>
    </section>
@endsection
