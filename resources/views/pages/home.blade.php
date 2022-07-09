@extends('layouts.main_layout')
@section('title')
    Main Page
@endsection
@section('content')
    <main>
        <section class="mb-5">
            <div class="topImage text-center">
                <div class="mac-text">
                    Creative Design
                </div>
                <form action="{{route('books')}}">
                    @csrf
                    <button type="submit" class="btn  btn-outline-warning">Books</button>
                </form>


                <p class="description">Take IngramSpark's FREE Online Self-Publishing Course on Optimizing Book
                    Metadata</p>
            </div>
        </section>
        <section class="aboutUs mt-5">
            <div class="container">
                <div class="aboutinformation shadow rounded p-5">
                    <h3> About Us</h3>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda soluta nisi cumque nostrum
                        porro repellat iusto neque quos asperiores, aliquam.
                    </p>
                    <p> Adipisicing elit. Modi similique iusto voluptatibus sint.
                    </p>
                    <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dignissimos modi molestias
                    </p>
                    <p>voluptas possimus perferendis saepe soluta accusantium, obcaecati neque quas ducimus, alias
                        labore
                    </p>
                   <p>
                       nesciunt atque ab voluptatibus quis! Molestiae dicta reprehenderit, quod laborum voluptatem
                       laboriosam! Sapiente vel, fugiat voluptates.
                   </p>

                  <p>  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem, quis!</p>
                </div>
            </div>
        </section>
        <section id="contact" class="contactUs mt-5 p-5 rounded">
            <div class="container contactUs-container ">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control inputContact" id="name" placeholder="Name">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class=" inputContact form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Your Massage</label>
                    <textarea  class="form-control inputContact" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-warning">Warning</button>
                </div>
            </div>
        </section>
    </main>
@endsection
