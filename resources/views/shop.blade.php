@extends('layouts.app')

@section('scripts')
    <link rel="stylesheet" href="{{asset('/css/shop.css')}}">
    <script src="{{asset('/js/shop.js')}}"></script>
@endsection
@section('content')
    <div class="block shop">
        <div class="block_header">Магазин</div>
        <div class="block_content">
            <div class="items_list">
                @foreach($items as $i)
                <div class="item" data-item-id="{{$i->id}}">
                    <div class="item_image"><img src="{{asset($i->image)}}" alt=""></div>
                    <div class="item_name">{{$i->name}}</div>
                    <div class="item_description">{{$i->description}}</div>
                    <div class="item_buy button">Купить
                        <div class="item_price">
                            <span class="allPrice">
                                @if($i->days == '-1')
                                <span class="days">Навечно</span>
                                @else
                                <span class="days">{{$i->days}} дней</span>
                                @endif
                                <span class="price">{{$i->price}}</span>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection