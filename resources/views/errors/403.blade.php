@extends('errors::minimal')

@section('title', __('Prohibido'))
@section('code', 'Ops! 403')
@section('message', __($exception->getMessage() ?: 'Acceso no autorizado'))
