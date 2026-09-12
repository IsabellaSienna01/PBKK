@extends('layouts.app')

@section('title', 'Academic Profile')

@section('content')
    <section class="mx-auto grid max-w-6xl gap-12 px-6 py-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:px-8 lg:py-24">
        <div class="flex flex-col items-start gap-6">

            <div class="space-y-5">
                <h1 class="max-w-5xl text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl lg:text-6xl">
                    Hi, I'm <span class="text-blue-500">{{ $nama ?? 'Isabella Sienna Sulisthio' }}</span>
                </h1>
                <p class="max-w-xl text-lg leading-8 text-slate-600 text-justify">
                    I'm a third-year Informatics Engineering student at Institut Teknologi Sepuluh Nopember (ITS) with an interest in web development and data science. I enjoy learning new skills, exploring new technologies, and collaborating on meaningful projects. I'm always curious about how ideas can be turned into practical solutions while continuing to grow my technical and creative skills.                </p>
            </div>

            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('mahasiswa.show', ['nrp' => '5025241199']) }}" class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    View Profile
                </a>
                <a href="{{ route('agent.show', ['tema' => 'ai-optimizer']) }}" class="rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-blue-300 hover:text-blue-700">
                    Explore Agentic AI
                </a>
            </div>
        </div>

        <aside class="relative">
            <div class="absolute -inset-4 -z-10 rounded-3xl bg-blue-100/70"></div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex size-16 items-center justify-center rounded-2xl bg-slate-900 text-xl font-semibold text-white">
                            <img src="{{ $foto ?? asset('foto.png') }}" alt="Foto Mahasiswa" class="h-full w-full rounded-2xl object-cover">
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-slate-900">{{ $nama ?? 'Isabella Sienna Sulisthio' }}</p>
                            <p class="text-sm text-slate-500">{{ $nrp ?? '5025241199' }}</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Active Student</span>
                </div>

                <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wider text-slate-400">Program</dt>
                        <dd class="mt-1 font-medium text-slate-800">Informatics Engineering</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-wider text-slate-400">Institution</dt>
                        <dd class="mt-1 font-medium text-slate-800">ITS</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium uppercase tracking-wider text-slate-400">Current focus</dt>
                        <dd class="mt-1 font-medium text-slate-800">Web Development, Software Engineering, and Artificial Intelligence.</dd>
                    </div>
                </dl>
            </div>
        </aside>
    </section>

    <section class="border-y border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
            <div class="max-w-full space-y-3">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">About me</p>
                <h2 class="text-3xl font-semibold tracking-tight text-slate-950">A little about what I'm learning and building.</h2>
                <p class="leading-7 text-slate-600 text-justify">I'm an Informatics Engineering student at ITS with an interest in web development, data science, and technology. I enjoy learning new things, working on projects, and turning ideas into something useful.</p>
            </div>

            <div class="mt-10 grid border-y border-slate-200 sm:grid-cols-2 lg:grid-cols-4">
                <div class="border-b border-slate-200 py-5 sm:border-r sm:px-5 lg:border-b-0 lg:first:pl-0">
                    <p class="text-sm text-slate-500">Semester</p>
                    <p class="mt-1 text-lg font-semibold">5</p>
                </div>
                <div class="border-b border-slate-200 py-5 sm:px-5 lg:border-b-0 lg:border-r">
                    <p class="text-sm text-slate-500">Department</p>
                    <p class="mt-1 text-lg font-semibold">Informatics</p>
                </div>
                <div class="border-b border-slate-200 py-5 sm:border-r sm:px-5 lg:border-b-0">
                    <p class="text-sm text-slate-500">University</p>
                    <p class="mt-1 text-lg font-semibold">ITS</p>
                </div>
                <div class="py-5 sm:px-5 lg:pr-0">
                    <p class="text-sm text-slate-500">Current focus</p>
                    <p class="mt-1 text-lg font-semibold">Artificial Intelligence</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Current focus</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Areas I am actively exploring.</h2>
            </div>
            <div class="grid gap-5 sm:grid-cols-3">
                <article class="border-t-2 border-blue-500 pt-4">
                    <h3 class="font-semibold">Web Development</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Crafting accessible, maintainable web interfaces.</p>
                </article>
                <article class="border-t-2 border-blue-500 pt-4">
                    <h3 class="font-semibold">Software Engineering</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Turning requirements into clear, reliable systems.</p>
                </article>
                <article class="border-t-2 border-blue-500 pt-4">
                    <h3 class="font-semibold">Artificial Intelligence</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-600">Exploring practical AI for everyday workflows.</p>
                </article>
            </div>
        </div>

        <article class="mt-16 flex flex-col gap-6 rounded-2xl border border-blue-100 bg-blue-50 p-7 sm:p-9 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-4xl space-y-3">
                <p class="text-sm font-semibold text-blue-700">Semester Project</p>
                <h2 class="text-2xl font-semibold tracking-tight text-slate-950">Exploring Our Agentic AI Idea.</h2>
                <p class="leading-7 text-slate-600">Our idea focuses on analyzing token usage, improving prompts, and recommending suitable AI models to make interactions more efficient.</p>
            </div>
            <a href="{{ route('agent.show', ['tema' => 'ai-optimizer']) }}" class="shrink-0 rounded-lg border border-blue-200 bg-white px-5 py-3 text-sm font-semibold text-blue-700 transition hover:border-blue-400 hover:bg-blue-600 hover:text-white">
                View Project Idea
            </a>
        </article>
    </section>
@endsection
