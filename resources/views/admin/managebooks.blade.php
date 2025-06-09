@include('component.navbar')
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>manage</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Books List</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($books->isEmpty())
        <div class="alert alert-warning">
            No books found.
        </div>
    @else
        <table class="table table-bordered table-striped shadow-sm">
            <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Added On</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ \Carbon\Carbon::parse($book->created_at)->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('app_edit_book',['id'=>$book->id]) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('app_delete_book', ['id' => $book->id]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

</body>
</html>
