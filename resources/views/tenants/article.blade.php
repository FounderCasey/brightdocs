@extends('layouts.tenant')

@section('content')
    <div>
    <h2>{{$article->title}}</h2>
      <div>{!!html_entity_decode($article->content)!!}</div>
    </div>
@endsection