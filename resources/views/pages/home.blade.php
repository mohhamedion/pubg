@extends('layouts.app')

@section('content')
    @if ($is_admin)
        @include('admin.home')

        @push('styles')
            {!! Charts::assets() !!}
        @endpush
    @else
        @include('manager.home')
    @endif
@endsection