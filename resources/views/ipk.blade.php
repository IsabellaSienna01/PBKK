@extends('layouts.app')

@section('title', 'GPA Calculator')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-14 lg:px-8 lg:py-20">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Academic Portfolio</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">GPA Calculator</h1>
            <p class="mt-5 text-lg leading-8 text-slate-600">Enter two semester GPA values to view the calculated average.</p>
        </div>

        <form
            id="gpa-calculator-form"
            class="mt-12"
            data-calculator-url="{{ route('ipk.calculate', ['ip1' => '__IP1__', 'ip2' => '__IP2__']) }}"
            novalidate
        >
            <div class="grid gap-5 md:grid-cols-2">
                <article class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <label for="gpa-ip1" class="text-sm font-medium text-slate-500">Semester 1 GPA</label>
                    <input
                        id="gpa-ip1"
                        name="ip1"
                        type="number"
                        min="0"
                        max="4"
                        step="0.01"
                        inputmode="decimal"
                        value="{{ $ip1 ?? '3.75' }}"
                        class="mt-4 w-full border-b-2 border-slate-200 bg-transparent pb-2 text-5xl font-semibold tracking-tight text-slate-950 outline-none transition focus:border-blue-600"
                        aria-describedby="gpa-form-error"
                    >
                    <div class="mt-6 h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                        <div data-gpa-bar="ip1" class="h-full rounded-full bg-blue-600 transition-[width] duration-200"></div>
                    </div>
                </article>

                <article class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <label for="gpa-ip2" class="text-sm font-medium text-slate-500">Semester 2 GPA</label>
                    <input
                        id="gpa-ip2"
                        name="ip2"
                        type="number"
                        min="0"
                        max="4"
                        step="0.01"
                        inputmode="decimal"
                        value="{{ $ip2 ?? '3.80' }}"
                        class="mt-4 w-full border-b-2 border-slate-200 bg-transparent pb-2 text-5xl font-semibold tracking-tight text-slate-950 outline-none transition focus:border-blue-600"
                        aria-describedby="gpa-form-error"
                    >
                    <div class="mt-6 h-1.5 w-full overflow-hidden rounded-full bg-slate-100">
                        <div data-gpa-bar="ip2" class="h-full rounded-full bg-blue-600 transition-[width] duration-200"></div>
                    </div>
                </article>
            </div>

            <p id="gpa-form-error" class="mt-4 hidden text-sm font-medium text-red-600" role="alert"></p>

            @if (isset($errorMessage))
                <section class="mt-5 max-w-2xl rounded-xl border border-amber-200 bg-amber-50 p-7">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-700">Input tidak valid</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">Nilai IPK tidak dapat dihitung.</h2>
                    <p class="mt-3 leading-7 text-slate-600">{{ $errorMessage }}</p>
                </section>
            @endif

            <section class="mt-5 rounded-2xl bg-slate-900 px-7 py-10 text-white sm:px-10 sm:py-12">
                <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-end">
                    <div>
                        <p class="text-sm font-medium text-slate-300">Cumulative Average</p>
                        <p data-gpa-average class="mt-3 text-7xl font-semibold tracking-tighter sm:text-8xl">{{ $ipk ?? '3.78' }}</p>
                        <p class="mt-5 max-w-md leading-7 text-slate-300">Live preview based on the two GPA values above.</p>
                    </div>
                    <div class="border-l border-slate-700 pl-6">
                        <p class="text-sm font-medium text-slate-300">Total Two-Semester GPA</p>
                        <p data-gpa-total class="mt-2 text-2xl font-semibold">{{ $totalIp ?? '7.55' }}</p>
                        <p class="mt-6 text-sm font-medium text-slate-300">Academic Performance</p>
                        <p class="mt-2 text-2xl font-semibold">Excellent</p>
                        <p class="mt-3 text-sm leading-6 text-slate-400">Press Calculate GPA to open the server-calculated result.</p>
                    </div>
                </div>
            </section>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Calculate GPA
                </button>
            </div>
        </form>
    </section>
@endsection
