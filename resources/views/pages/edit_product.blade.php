@extends('master_one_column')
@section('main')
    <div class="row">
        <div class="col">
            <script type="text/javascript">
                var currentProductId = {{$product->id}};
                var allowImgNb = {{$allowImgNb}};
            </script>
            <p class="text-red font-weight-bold">
               Cập nhật tin: "{{$product->title}}"
            </p>
            <p>Bạn còn {{$product->edit_times}} lần chỉnh sửa.</p>
            <input type="hidden" name="edit_id" value="{{$product->id}}"/>
            <div class="tab-content">
                <div class="card card-tab">
                    <div class="card-body">
                        @include('partials.create-'.$editView)
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection