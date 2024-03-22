<!DOCTYPE html>
<html>
<head>
    <title>Job Request Response Alert!</title>
</head>
<body>
    <p>{{ $details['user']['name'] }} has {{ $details['response'] }} your request</p>

    @if($details['response'] == 'accepted')
      <p>Here's the Technician contact information.</p>
      <ul>
        <li>Phone number : {{ $details['user']['phone'] }}</li>
        <li>Email        : {{ $details['user']['email'] }}</li>
      </ul>
    @else
      <p>to contact another technician please Login!</p>
    @endif
</body>
</html>