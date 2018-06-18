<ul class="media-list">
@foreach ($microposts as $micropost)
    <?php $user = $micropost->user; ?>
    <li class="media">
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
            
            <!--返信ボタン-->
            <div>
                {!! Form::open(['route' => ['microposts.reply', $micropost->id]]) !!}
                {!! Form::submit('Reply', ['class' => "btn btn-primary btn-xs"]) !!}
                {!! Form::close() !!}
            </div>
            <div>
                @if (Auth::user()->id == $micropost->user_id)
                    {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                @endif
                @include('post_favorite.favorite_button', ['micropost' => $micropost])
                
                <!--返信内容の表示-->
                @if($micropost_childs[$micropost->id]??null != null)
                    @foreach($micropost_childs[$micropost->id]??array() as $micropost_child)
                        
                        <div class="media-left">
                            <img class="media-object img-rounded" src="{{ Gravatar::src($micropost_child->user->email, 50) }}" alt="">
                        </div>
                    <div class="media-body"> 
                        <div>
                            {!! link_to_route('users.show', $micropost_child->user->name, ['id' => $micropost_child->user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                        </div>
                        <div>
                            <p>{!! nl2br(e($micropost_child->content)) !!}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
                
                
            </div>
        </div>
    </li>
@endforeach
</ul>
{!! $microposts->render() !!}