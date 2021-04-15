@extends('layouts.app')

@section('content')
    <div class="container-fluid">
{{--        {{$heading}} {{$CRUD_Action}} {{$dcip}}--}}
{{--        {{$missingpersons}}--}}
        <missingpersonlist></missingpersonlist>
    </div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'List', 'includeStyle' => true, 'includeScript' => true])
    @parent
    <style>

    </style>
    <script>

    </script>
@endsection
<script>
</script>