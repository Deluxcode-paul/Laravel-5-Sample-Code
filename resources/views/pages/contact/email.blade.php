<p>Inquiry Type : {{ $values['inquiry_type'] }}</p>
<p>Full Name : {{ $values['full_name'] }}</p>
<p>Email : {{ $values['email'] }}</p>
<p>Message :</p>
<p>{!! nl2br(e($values['message'])) !!}</p>
