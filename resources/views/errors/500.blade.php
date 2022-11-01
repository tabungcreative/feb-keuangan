@extends('errors.minimal')

@section('title', __('Server Error'))
@section('code', '419')
@section('message', $message ?? '')
