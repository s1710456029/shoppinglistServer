<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>
    <ul>
        @foreach ( $lists as $list )
            <li><a href= "lists/ {{$list->id}}">{{$list->title}}</a></li>
        @endforeach
    </ul >
</body >
</html >