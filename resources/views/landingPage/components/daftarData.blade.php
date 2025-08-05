@extends('landingPage.main')

@section('title', 'Daftar Data - Portal Desa')

@section('content')
    @include('landingPage.components.daftarData.styles')

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Daftar Data</h1>
            <p>Pusat informasi dan data terpadu untuk transparansi dan akuntabilitas</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Daftar Data</span>
            </nav>
        </div>
    </section>

    <!-- Data Categories Section -->
    @include('landingPage.components.daftarData.categories')

    <!-- Data Tables Section -->
    @include('landingPage.components.daftarData.dataTables')

    <!-- Statistics Section -->
    @include('landingPage.components.daftarData.statistics')

    <!-- Reports & Publications Section -->
    @include('landingPage.components.daftarData.reports', ['featuredReports' => $featuredReports])

    <!-- Modals -->
    @include('landingPage.components.daftarData.modals')

    <!-- JavaScript -->
    @include('landingPage.components.daftarData.scripts')

@endsection
