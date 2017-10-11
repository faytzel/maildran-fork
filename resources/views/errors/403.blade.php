@extends('layouts.app')

@section('title', trans('title.errors.403'))

@section('content')

    <h1>@lang('error.403.title')</h1>

    <p>@lang('error.403.msg1').</p>

@endsection
