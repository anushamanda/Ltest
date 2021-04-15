@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <viz-main type="{{$type}}"></viz-main>
        </v-col>
    </v-row>
@endsection