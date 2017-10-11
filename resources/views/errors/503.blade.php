@extends('layouts.app')

@section('title', trans('title.errors.503'))

@section('content')

    <h1>@lang('error.503.title')</h1>

    <p>@lang('error.503.msg1').</p>

@endsection
