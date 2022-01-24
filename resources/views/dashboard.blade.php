@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards', [$qtd_usuarios, $veiculos])
    
    
    <div class="container-fluid mt--7">
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush