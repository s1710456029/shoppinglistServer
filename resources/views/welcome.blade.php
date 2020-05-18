<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1>Hello World</h1>

    <ul>
        @foreach($lists as $list)
            <li>{{$list->title}} {{$list->until}}</li>
        @endforeach
    </ul>
</body>
</html>