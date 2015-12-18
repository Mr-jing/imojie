@extends('layout.default')

@section('title')个人主页
@stop

@section('content')
    {{$user->email}}
@stop