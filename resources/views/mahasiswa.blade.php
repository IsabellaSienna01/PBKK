@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-14 lg:px-8 lg:py-20">
        <div class="border-b border-slate-200 pb-8 dark:border-slate-700">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">Student Profile</p>
            <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">Academic Information</h1>
        </div>

        <section class="flex flex-col gap-6 border-b border-slate-200 py-10 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-5">
                <div class="flex size-20 items-center justify-center rounded-2xl bg-slate-900 text-2xl font-semibold text-white">
                    <img src="{{ $foto ?? asset('foto.png') }}" alt="Foto Mahasiswa" class="h-full w-full rounded-2xl object-cover">
                </div>
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight">{{ $nama ?? 'Isabella Sienna Sulisthio' }}</h2>
                    <p class="mt-1 text-slate-500 dark:text-slate-400">NRP {{ $nrp ?? '5025XXXXXXXX' }}</p>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Informatics Engineering · Institut Teknologi Sepuluh Nopember</p>
                </div>
            </div>
            <span class="w-fit rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-sm font-medium text-blue-700 dark:border-blue-800 dark:bg-blue-950 dark:text-blue-300">Semester 5</span>
        </section>

       <div class="grid gap-14 py-14 lg:grid-cols-[0.9fr_1.1fr]">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    Quick Profile
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    A little more about me.
                </h2>

                <p class="mt-3 max-w-md leading-7 text-slate-600 dark:text-slate-300">
                    A quick look at what I'm currently learning, exploring, and working on.
                </p>
            </section>

            <dl class="grid gap-4 sm:grid-cols-2">
                <x-info-card title="Study">Informatics Engineering</x-info-card>
                <x-info-card title="Entry Year">2024</x-info-card>
                <x-info-card title="Main Interest">Web Development</x-info-card>
                <x-info-card title="Currently Learning">Data Science &amp; AI</x-info-card>
                <x-info-card title="Current Project">AI Token &amp; Prompt Optimizer</x-info-card>
                <x-info-card title="Open To">Projects &amp; Collaboration</x-info-card>
            </dl>
        </div>

       

        <div class="grid gap-14 border-t border-slate-200 py-14 dark:border-slate-700 lg:grid-cols-2">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">Skills / Technologies</p>
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach (['C', 'C++', 'Python', 'SQL', 'Laravel', 'Next.js', 'PostgreSQL', 'Git', 'Figma', 'Canva', 'Many more'] as $skill)
                        <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">{{ $skill }}</span>
                    @endforeach
                </div>
            </section>

            <section class="border-l-0 border-slate-200 dark:border-slate-700 lg:border-l lg:pl-14">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">Current Academic Focus</p>
                <h2 class="mt-3 text-xl font-semibold">Building Better Software Foundations.</h2>
                <p class="mt-3 leading-7 text-slate-600 dark:text-slate-300">Current learning priorities include software architecture, web application development, and practical artificial intelligence concepts.</p>
            </section>
        </div>
    </section>
@endsection
