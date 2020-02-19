@extends('layouts.tenant')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">

        <!-- New Article Form -->
        <form action="/article" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Article Name -->
            <div class="form-group">
              <label for="article-title">Article Title</label>

                <div>
                    <input type="text" name="title" id="article-title">
                </div>

                <label for="article-content">Article Content</label>

                <div>
                    <textarea name="content" id="article-content" cols="30" rows="10"></textarea>
                </div>
            </div>

            <!-- Add Article Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Create Article
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection