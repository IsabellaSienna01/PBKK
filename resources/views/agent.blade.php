@extends('layouts.app')

@section('title', 'Agentic AI Idea')
@section('content')
    <section class="mx-auto max-w-6xl px-6 py-14 lg:px-8 lg:py-20">
        @if (session('idea_success'))
            <x-status-banner type="success" class="mb-8">{{ session('idea_success') }}</x-status-banner>
        @endif

        <div class="grid gap-10 border-b border-slate-200 pb-14 dark:border-slate-700 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
            <div>

                <h1 class="mt-3 max-w-3xl text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">
                    AI Token & Prompt Optimizer
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">
                    An Agentic AI platform that analyzes prompt token usage, suggests more efficient prompts,
                    and recommends suitable AI models based on the user's task.
                </p>
            </div>

            <div class="border-l-4 border-blue-600 bg-white p-6 shadow-sm dark:border-blue-400 dark:bg-slate-800">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Project Direction</p>
                <p class="mt-3 text-xl font-semibold leading-8 text-slate-900 dark:text-slate-100">
                    Helping users get better AI results while using fewer tokens and choosing the right model.
                </p>
            </div>
        </div>

        <div class="grid gap-14 py-14 lg:grid-cols-2">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    Problem
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    AI prompts can use more tokens than necessary.
                </h2>

                <p class="mt-4 leading-7 text-slate-600 dark:text-slate-300">
                    Users often write long or repetitive prompts without knowing how many tokens are being used.
                    They may also choose a more powerful AI model than necessary for a simple task, which can
                    increase token usage and cost.
                </p>
            </section>

            <section class="border-l-0 border-slate-200 dark:border-slate-700 lg:border-l lg:pl-14">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    Proposed Solution
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    Analyze the prompt before sending it to an AI model.
                </h2>

                <p class="mt-4 leading-7 text-slate-600 dark:text-slate-300">
                    Our platform analyzes the user's prompt, estimates its token usage, identifies unnecessary
                    parts, and suggests a more efficient version. It also recommends an AI model that is suitable
                    for the task.
                </p>
            </section>
        </div>

        <section class="border-y border-slate-200 bg-white py-14 dark:border-slate-700 dark:bg-slate-900">
            <div class="px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    How It Works
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    From a user's prompt to a more efficient AI request.
                </h2>

                <div class="mt-10 grid gap-4 md:grid-cols-4">
                    <article class="border border-slate-200 p-5 dark:border-slate-700">
                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">01</span>

                        <h3 class="mt-6 font-semibold">Input Prompt</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            The user enters the prompt they want to use.
                        </p>
                    </article>

                    <article class="border border-slate-200 p-5 dark:border-slate-700">
                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">02</span>

                        <h3 class="mt-6 font-semibold">Token Analysis</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            The system estimates token usage and analyzes the structure of the prompt.
                        </p>
                    </article>

                    <article class="border border-slate-200 p-5 dark:border-slate-700">
                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">03</span>

                        <h3 class="mt-6 font-semibold">Prompt Optimization</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            The agent suggests a shorter and more efficient prompt while keeping the original intent.
                        </p>
                    </article>

                    <article class="border border-slate-200 p-5 dark:border-slate-700">
                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">04</span>

                        <h3 class="mt-6 font-semibold">Model Recommendation</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            The system recommends a suitable AI model based on the task and expected efficiency.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <div class="grid gap-14 py-14 lg:grid-cols-[1.2fr_0.8fr]">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    Core Capabilities
                </p>

                <ul class="mt-6 grid gap-4 sm:grid-cols-2">
                    <li class="border-t border-slate-200 pt-4 text-slate-700 dark:border-slate-700 dark:text-slate-200">
                        Estimate prompt token usage
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700 dark:border-slate-700 dark:text-slate-200">
                        Detect unnecessary or repetitive prompt content
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700 dark:border-slate-700 dark:text-slate-200">
                        Suggest more efficient prompts
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700 dark:border-slate-700 dark:text-slate-200">
                        Preserve the original prompt intention
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700 dark:border-slate-700 dark:text-slate-200">
                        Recommend suitable AI models
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700 dark:border-slate-700 dark:text-slate-200">
                        Compare token usage before and after optimization
                    </li>
                </ul>
            </section>

            <section class="rounded-xl border border-slate-200 bg-slate-50 p-6 dark:border-slate-700 dark:bg-slate-900">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                    Technology Exploration
                </p>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">
                        LLM
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">
                        Agentic AI
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">
                        Tokenization
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">
                        Prompt Engineering
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">
                        Model Selection
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">
                        API
                    </span>
                </div>
            </section>
        </div>

    <section id="submit-idea" class="border-t border-slate-200 py-14 dark:border-slate-700">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">
                Idea Submission Form
            </p>

            <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                Share Your Agentic AI Idea.
            </h2>

            <p class="mt-3 leading-7 text-slate-600 dark:text-slate-300">
                We truly appreciate your idea and contribution.
            </p>
        </div>

        @if ($errors->any())
            <div class="mt-8 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-200" role="alert">
                <p class="font-semibold">Please review the following fields:</p>

                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('agent.idea.submit') }}" method="POST" class="mt-8 grid gap-5">
            @csrf

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-semibold">
                        Name
                    </label>

                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="{{ old('nama') }}"
                        maxlength="100"
                        required
                        class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:ring-blue-900"
                    >
                </div>

                <div>
                    <label for="judul_ide" class="block text-sm font-semibold">
                        Idea Title
                    </label>

                    <input
                        id="judul_ide"
                        name="judul_ide"
                        type="text"
                        value="{{ old('judul_ide') }}"
                        maxlength="150"
                        required
                        class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:ring-blue-900"
                    >
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-semibold">
                    Idea Description
                </label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="5"
                    maxlength="2000"
                    required
                    class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:focus:ring-blue-900"
                >{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-950"
                >
                    Submit Idea
                </button>
            </div>
        </form>
    </section>

@endsection
