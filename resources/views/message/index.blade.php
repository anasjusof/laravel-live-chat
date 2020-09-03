<div class="message-wrapper">
    @foreach($messages as $message)
    <ul class="messages">
        <li class="message clearfix">
            <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                <p>{{ $message->message }}</p>
                <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at))  }}</p>
            </div>
        </li>
    </ul>
    @endforeach
</div>
<div class="input-text">
    <input type="text" name="message" class="submit">
</div>