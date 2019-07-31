@extends('master')
@section('title')
    <title>Hòm thư | VietnamAds</title>
@endsection
@section('meta-tags')
    <meta name="description" content="Hòm thư cá nhân">
@endsection
@section('main')
    <div class="messaging" id="message-box-page">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    {{--<div class="recent_heading">--}}
                        {{--<h4>Recent</h4>--}}
                    {{--</div>--}}
                    {{--<div class="srch_bar">--}}
                        {{--<div class="stylish-input-group">--}}
                            {{--<input type="text" class="search-bar" placeholder="Search">--}}
                            {{--<span class="input-group-addon">--}}
                {{--<button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>--}}
                {{--</span></div>--}}
                    {{--</div>--}}
                </div>
                <div class="inbox_chat">
                    @foreach($senderList as $item)
                        <div class="chat_list btn-load-message"
                                data-from-id="{{$item->id}}"
                            >
                            <div class="chat_people">
                                <div class="chat_img"> <img
                                            class="user-avatar"
                                            src="{{$item->getAvatarUrl()}}"
                                                            alt="{{$item->name}}"> </div>
                                <div class="chat_ib btn-load">
                                    <h5>{{$item->name}} <span class="chat_date"></span></h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history" id="message-content-list">

                </div>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="hidden" name="to_user" value="" id="reply_to_id">
                        <input type="text" class="write_msg form-control" id="reply_content"
                               placeholder="Gõ tin nhắn" />
                        <button class="msg_send_btn" type="button" id="btn-reply-message">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection