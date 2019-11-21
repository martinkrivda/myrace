@extends('adminlte::page')

@section('htmlheader_title')
    {{ trans('title.assignTag') }}
@endsection
@section('contentheader_title')
    {{ trans('title.assignTagRunner') }}
@endsection


@section('main-content')
<assign-tag :edition='{!! json_encode($edition_ID) !!}'></assign-tag>
@endsection
@section('scripts')
@parent
<script type="text/javascript">

</script>
@endsection
