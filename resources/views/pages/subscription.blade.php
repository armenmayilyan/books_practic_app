@extends('layouts.main_layout')
@section('title')
    Pages Subscription
@endsection
@section('content')
    @if(!auth()->user()->activeSubscription())
    @foreach($plans as $plan)
        <form class="text-center" action="{{route('subscription.store')}}" method="post">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <div class=" mt-5 p-5 d-flex justify-content-center">
                <div class="card w-25">
                    <h5 class="card-header">{{$plan->name}}</h5>
                    <div class="card-body">
                        <h5 class="card-title">limit {{$plan->limit}}</h5>
                        <p class="card-text">{{$plan->price}} $</p>
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_51LAVVYJpHB8lQVV6iJIRr9nvY59eRjXSSjpKz7mIlXwlioOLfHFy6nnFex2T9s6KCh6lwcJCffHydrRCCDdFtXxb00Ryzw28aO"
                            data-name="BookStore"
                            data-description="Subscribe"
                            data-image="../img/mac.jpg"
                            data-email="{{ auth()->check()?auth()->user()->email: null}}"
                            data-panel-label="Pay Monthly {{$plan->price}} dollars"
                            data-locale="auto">
                        </script>

                    </div>
                </div>

            </div>

        </form>
    @endforeach
    @else
        <div class="text-center" style="margin-top: 100px">
            <h1 class="color:danger">
                Your have subscription
            </h1>
            <a  class="btn btn-dark  btn-lg" href="{{route('subId',[$active->id])}}">cansel</a>
        </div>
    @endif





@endsection
