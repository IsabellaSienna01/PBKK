@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-14 lg:px-8 lg:py-20">
        <div class="border-b border-slate-200 pb-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Student Profile</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">Academic Information</h1>
        </div>

        <section class="flex flex-col gap-6 border-b border-slate-200 py-10 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-5">
                <div class="flex size-20 items-center justify-center rounded-2xl bg-slate-900 text-2xl font-semibold text-white">
                    <img src="{{ $foto ?? asset('foto.png') }}" alt="Foto Mahasiswa" class="h-full w-full rounded-2xl object-cover">
                </div>
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight">{{ $nama ?? 'Isabella Sienna Sulisthio' }}</h2>
                    <p class="mt-1 text-slate-500">NRP {{ $nrp ?? '5025XXXXXXXX' }}</p>
                    <p class="mt-2 text-sm text-slate-600"> Informatics Engineering · Institut Teknologi Sepuluh Nopember</p>
                </div>
            </div>
            <span class="w-fit rounded-full border border-blue-200 bg-blue-50 px-3 py-1.5 text-sm font-medium text-blue-700">Semester 5</span>
        </section>

       <div class="grid gap-14 py-14 lg:grid-cols-[0.9fr_1.1fr]">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">
                    Quick Profile
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    A little more about me.
                </h2>

                <p class="mt-3 max-w-md leading-7 text-slate-600">
                    A quick look at what I'm currently learning, exploring, and working on.
                </p>
            </section>

            <dl class="grid border-t border-slate-200 sm:grid-cols-2">
                <div class="border-b border-slate-200 py-5 sm:border-r sm:pr-8">
                    <dt class="text-sm text-slate-500">Study</dt>
                    <dd class="mt-1 font-medium">Informatics Engineering</dd>
                </div>

                <div class="border-b border-slate-200 py-5 sm:pl-8">
                    <dt class="text-sm text-slate-500">Entry Year</dt>
                    <dd class="mt-1 font-medium">2024</dd>
                </div>

                <div class="border-b border-slate-200 py-5 sm:border-r sm:pr-8">
                    <dt class="text-sm text-slate-500">Main Interest</dt>
                    <dd class="mt-1 font-medium">Web Development</dd>
                </div>

                <div class="border-b border-slate-200 py-5 sm:pl-8">
                    <dt class="text-sm text-slate-500">Currently Learning</dt>
                    <dd class="mt-1 font-medium">Data Science & AI</dd>
                </div>

                <div class="border-b border-slate-200 py-5 sm:border-r sm:pr-8">
                    <dt class="text-sm text-slate-500">Current Project</dt>
                    <dd class="mt-1 font-medium">AI Token & Prompt Optimizer</dd>
                </div>

                <div class="border-b border-slate-200 py-5 sm:pl-8">
                    <dt class="text-sm text-slate-500">Open To</dt>
                    <dd class="mt-1 font-medium">Projects & Collaboration</dd>
                </div>
            </dl>
        </div>

       

        <div class="grid gap-14 border-t border-slate-200 py-14 lg:grid-cols-2">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Skills / Technologies</p>
                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">C</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">C++</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Python</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">SQL</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Laravel</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Next.js</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">PostgreSQL</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Git</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Figma</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Canva</span>
                    <span class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700">Many more</span>
                </div>
            </section>

            <section class="border-l-0 border-slate-200 lg:border-l lg:pl-14">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Current Academic Focus</p>
                <h2 class="mt-3 text-xl font-semibold">Building Better Software Foundations.</h2>
                <p class="mt-3 leading-7 text-slate-600">Current learning priorities include software architecture, web application development, and practical artificial intelligence concepts.</p>
            </section>
        </div>
    </section>
@endsection
