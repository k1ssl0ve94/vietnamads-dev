@foreach($items as $item)
    @if($item->from_user === $fromUser->id)
        <div class="incoming_msg msg-item">
            <div class="incoming_msg_img">
                <img src="{{$fromUser->getAvatarUrl()}}" class="user-avatar"
                     alt="{{$item->name}}"> </div>
            <div class="received_msg">
                <div class="received_withd_msg">
                    <p>{{$item->content}}</p>
                    <span class="time_date"> {{$item->created_at->format('H:i')}}
                        |    {{$item->created_at->format('d/m/Y')}}</span> </div>
            </div>
        </div>
    @else
        <div class="outgoing_msg msg-item">
            <div class="sent_msg">
                <p>{{$item->content}}</p>
                <span class="time_date"> {{$item->created_at->format('H:i')}}
                    |    {{$item->created_at->format('d/m/Y')}}</span> </div>
        </div>
    @endif
@endforeach
