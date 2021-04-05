<html>
<head>
    <meta>
</head>
<body>
<table border="1">
@foreach($items as $item)
<tr>
    <td>{{$item->id}}</td>
    <td>{{$item->byer_name}}</td>
    <td>{{$item->order_name}}</td>
    <td>created_at: {{$item->created_at}}</td>
       <td>
        @foreach($item->books as $book)
            <br>{{$book->name}} -> {{$book->author->name}} ->{{$book->pivot->paid ? 'true' : 'false'}}

        @endforeach
    </td>
    <td>
{{--        @if(!empty($item->address)){{$item->address->text}}@endif--}}
    </td>
</tr>
@endforeach
</table>
</body>
</html>
