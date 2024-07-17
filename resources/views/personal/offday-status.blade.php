@extends('layouts.panel')

@section('content')

<section id="main" class="col-lg-10 p-4">
    <div class="table-list table-responsive col-12">
        <h1 class="title-text mb-4">İzin Durumları</h1>
        <p class="">
            İzin Gün Sayısı: <span class="badge text-bg-dark">{{ Auth::user()->offday }}</span>
        </p>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($dayRequests->isEmpty())
            <div class="w-3/4 mx-auto mt-4 text-center text-gray-500 dark:text-gray-400">
                <h5>Henüz hiç izin talebi yok</h5>
            </div>
        @else
            <table class="table table-striped table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col">Başlangıç T.</th>
                        <th scope="col">Bitiş T.</th>
                        <th scope="col">Gün Sayısı</th>
                        <th scope="col">Durum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dayRequests as $days)
                        <tr>
                            <td>{{ $days->start_date }}</td>
                            <td>{{ $days->end_date }}</td>
                            <td>{{ $days->daysRequested }}</td>
                            <td>
                                @if ($days->status == 'Pending')
                                    <span class="badge text-bg-warning">Bekliyor</span>
                                @elseif ($days->status == 'approved')
                                    <span class="badge text-bg-success">Onaylandı</span>
                                @elseif ($days->status == 'rejected')
                                    <span class="badge text-bg-danger">Reddedildi</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</section>

@stop


{{-- <x-app-layout>
    <div class="container text-center mx-auto mt-4 px-6">
        <h1 class="ml-auto font-semibold mb-4 text-white">İzin Gün Sayısı: {{ Auth::user()->offday }}</h1>
    </div>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <table class="w-3/4 mx-auto text-base text-left text-gray-500 dark:text-gray-400">
        <thead class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Başlangıç</th>
                <th scope="col" class="px-6 py-3">Bitiş</th>
                <th scope="col" class="px-6 py-3">İzin Günü</th>
                <th scope="col" class="px-6 py-3">Durum</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dayRequests as $days)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $days->start_date }}</td>
                <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $days->end_date }}</td>
                <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $days->daysRequested }}</td>
                <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    @if ($days->status == 'Pending')
                    Bekleniyor
                    @elseif ($days->status == 'approved')
                    Onaylandı
                    @elseif ($days->status == 'rejected')
                    Reddedildi
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</x-app-layout> --}}