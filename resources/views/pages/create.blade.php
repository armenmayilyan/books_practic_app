@extends('layouts.main_layout')
@section('title')
    Create Your Book
@endsection
@section('content')

    <main>
        <section>
            <div class="container contact-form">
                <div class="contact-image">
                    <img src="https://image.ibb.co/kUagtU/rocket_contact.png" alt="rocket_contact"/>
                </div>
                <form method="post" action="{{route('createBook')}}" enctype="multipart/form-data">
                    @csrf
                    <h3>Create Your Book</h3>`
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Your Book Name *"
                                       value=""/>
                            </div>
                            <div class="mb-3">
                                <input class="form-control form-control-sm" id="formFileSm" name="bookFile" type="file">
                            </div>
                            <div class="mb-3">
                                <input class="form-control form-control-sm" id="formFileSm" name="bookpdf" type="file"
                                       accept=".pdf,.doc">
                            </div>

                            <div class="form-group">
                                <input type="number" name="price" class="form-control" placeholder="Price *" value=""/>
                            </div>
                                <div class="form-group">
                                    <input type="submit" name="btnSubmit" class="btnContact" value="Create Book"/>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea name="description" class="form-control" placeholder="Your Description *"
                                          style="width: 100%; height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>









@endsection
