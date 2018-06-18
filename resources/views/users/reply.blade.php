@extends('layouts.app')

@section('content')
    <div class="row">
        <!--<aside class="col-xs-4">-->
          ポストID
           <?php
           print $micropost->id;
           print $micropost->content;
           ?>
           
        <?php $user = $micropost->user; ?>
       <!-- <li class="media">-->
            <div class="media-left">
                <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
            </div>
            
            <div class="media-body">
                <div>
                    {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                </div>
                
                <div>
                    <p>{!! nl2br(e($micropost->content)) !!}</p>
                </div>

           
                  <!--'method'=>'put'を[]内に記述すると，複数の変数をコントローラーに渡せるようになった-->
           
                  {!! Form::open(['route' => ['microposts.update', $micropost->id],'method'=>'put']) !!}
                      <div class="form-group">
                          {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
                          {!! Form::submit('Reply', ['class' => 'btn btn-primary btn-block']) !!}
                      </div>
                  {!! Form::close() !!}
           
            </div>
            <!--</li>--> 
    </div>
@endsection