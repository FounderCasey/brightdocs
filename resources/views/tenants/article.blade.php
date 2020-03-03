@extends('layouts.tenant')

@section('content')
    <div>
      @foreach ($articles as $article)
        <h2>{{$article->title}}</h2>
        <p>{!! html_entity_decode($article->content) !!}</p>
      @endforeach
    </div>
@endsection