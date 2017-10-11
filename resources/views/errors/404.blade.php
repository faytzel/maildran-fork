@extends('layouts.app')

@section('title', trans('title.errors.404'))

@section('content')

    <h1>@lang('error.404.title')</h1>

    <p>@lang('error.404.msg1').</p>

@endsection
