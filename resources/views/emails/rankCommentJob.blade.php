<!DOCTYPE html>
<html>
<head>
    <title>Time to feedback!</title>
</head>
<body>
    <p>Recently {{ $details['technician'] }} worked for you as {{ $details['job'] }}
      we'd love you to give your feedback in the link below.</p>

       
    <a href="{{ $details['link'] }}"> Give feedback!</a>
</body>
</html>