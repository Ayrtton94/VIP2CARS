@extends('layouts.app')

@section('content')
<vehicles-edit :vehiculo-id="{{ $vehiculoId }}"></vehicles-edit>

@endsection