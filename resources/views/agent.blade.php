@extends('layouts.app')

@section('title', 'Agentic AI Idea')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-14 lg:px-8 lg:py-20">
        <div class="grid gap-10 border-b border-slate-200 pb-14 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
            <div>

                <h1 class="mt-3 max-w-3xl text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                    AI Token & Prompt Optimizer
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                    An Agentic AI platform that analyzes prompt token usage, suggests more efficient prompts,
                    and recommends suitable AI models based on the user's task.
                </p>
            </div>

            <div class="border-l-4 border-blue-600 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Project Direction</p>
                <p class="mt-3 text-xl font-semibold leading-8 text-slate-900">
                    Helping users get better AI results while using fewer tokens and choosing the right model.
                </p>
            </div>
        </div>

        <div class="grid gap-14 py-14 lg:grid-cols-2">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">
                    Problem
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    AI prompts can use more tokens than necessary.
                </h2>

                <p class="mt-4 leading-7 text-slate-600">
                    Users often write long or repetitive prompts without knowing how many tokens are being used.
                    They may also choose a more powerful AI model than necessary for a simple task, which can
                    increase token usage and cost.
                </p>
            </section>

            <section class="border-l-0 border-slate-200 lg:border-l lg:pl-14">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">
                    Proposed Solution
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    Analyze the prompt before sending it to an AI model.
                </h2>

                <p class="mt-4 leading-7 text-slate-600">
                    Our platform analyzes the user's prompt, estimates its token usage, identifies unnecessary
                    parts, and suggests a more efficient version. It also recommends an AI model that is suitable
                    for the task.
                </p>
            </section>
        </div>

        <section class="border-y border-slate-200 bg-white py-14">
            <div class="px-6 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">
                    How It Works
                </p>

                <h2 class="mt-3 text-2xl font-semibold tracking-tight">
                    From a user's prompt to a more efficient AI request.
                </h2>

                <div class="mt-10 grid gap-4 md:grid-cols-4">
                    <article class="border border-slate-200 p-5">
                        <span class="text-sm font-semibold text-blue-600">01</span>

                        <h3 class="mt-6 font-semibold">Input Prompt</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            The user enters the prompt they want to use.
                        </p>
                    </article>

                    <article class="border border-slate-200 p-5">
                        <span class="text-sm font-semibold text-blue-600">02</span>

                        <h3 class="mt-6 font-semibold">Token Analysis</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            The system estimates token usage and analyzes the structure of the prompt.
                        </p>
                    </article>

                    <article class="border border-slate-200 p-5">
                        <span class="text-sm font-semibold text-blue-600">03</span>

                        <h3 class="mt-6 font-semibold">Prompt Optimization</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            The agent suggests a shorter and more efficient prompt while keeping the original intent.
                        </p>
                    </article>

                    <article class="border border-slate-200 p-5">
                        <span class="text-sm font-semibold text-blue-600">04</span>

                        <h3 class="mt-6 font-semibold">Model Recommendation</h3>

                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            The system recommends a suitable AI model based on the task and expected efficiency.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <div class="grid gap-14 py-14 lg:grid-cols-[1.2fr_0.8fr]">
            <section>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">
                    Core Capabilities
                </p>

                <ul class="mt-6 grid gap-4 sm:grid-cols-2">
                    <li class="border-t border-slate-200 pt-4 text-slate-700">
                        Estimate prompt token usage
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700">
                        Detect unnecessary or repetitive prompt content
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700">
                        Suggest more efficient prompts
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700">
                        Preserve the original prompt intention
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700">
                        Recommend suitable AI models
                    </li>

                    <li class="border-t border-slate-200 pt-4 text-slate-700">
                        Compare token usage before and after optimization
                    </li>
                </ul>
            </section>

            <section class="rounded-xl border border-slate-200 bg-slate-50 p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">
                    Technology Exploration
                </p>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200">
                        LLM
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200">
                        Agentic AI
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200">
                        Tokenization
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200">
                        Prompt Engineering
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200">
                        Model Selection
                    </span>

                    <span class="rounded-md bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-200">
                        API
                    </span>
                </div>
            </section>
        </div>
    </section>
@endsection