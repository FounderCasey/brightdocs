@extends('layouts.tenant')

@section('content')
<home :tenant="{{json_encode(tenant('company'))}}"></home>
<tenant-foot :user="{{Auth::user() ?? '{name: ""}' }}"></tenant-foot>
@endsection
