<h2>Hello!</h2>
<p>You have received a new friend request from <strong>{{ $sender->name }}</strong>.</p>

<p>Email: {{ $sender->email }}</p>

<p>Log in to your account to accept or decline the request.</p>

<br>
<p>Thanks,</p>
<p>{{ config('app.name') }}</p>
