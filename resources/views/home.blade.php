@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <?php for($x=0 ; $x< 20; $x++) { ?>
                <ul class="user">
                    <span class="pending">1</span>

                    <div class="media">
                        <div class="media-left">
                            <img src="https://via.placeholder.com/150" alt="" class="media-object">
                        </div>

                        <div class="media-body">
                            <p class="name">Name</p>
                            <p class="email">Emial@email.com</p>
                        </div>
                    </div>
                </ul>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-8" id="messages">
            <div class="message-wrapper">
                <?php for($x=0 ; $x< 20; $x++) { ?>
                <ul class="messages">
                    <li class="message clearfix">
                        <div class="sent">
                            <p>Lorem Ipsum dolor</p>
                            <p class="date">1 Sep, 2019</p>
                        </div>
                    </li>

                    <li class="message clearfix">
                        <div class="received">
                            <p>Lorem Ipsum dolor</p>
                            <p class="date">1 Sep, 2019</p>
                        </div>
                    </li>

                </ul>
                <?php } ?>
            </div>
            <div class="input-text">
                <input type="text" name="message" class="submit">
            </div>
        </div>

        
    </div>
</div>
@endsection
