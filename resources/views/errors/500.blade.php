@extends('layouts.app')

@section('title', trans('title.errors.500'))

@section('content')

    <h1>@lang('error.500.title')</h1>

    <p>@lang('error.500.msg1').</p>

@endsection
