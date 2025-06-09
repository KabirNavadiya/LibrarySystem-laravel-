@include('component.navbar')
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EditBook</title>
</head>
<body>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container mt-4">
    <div class="card shadow rounded p-4">
        <h3 class="mb-4">Edit Book</h3>

        <form action="{{ route('app_edit_book_post',['id'=>$book->id])  }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title" value="{{ $book->title }}" >
                @error('title')
                <span style="color:red">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Enter author name" value="{{ $book->author }}">
                @error('author')
                <span style="color:red">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Edit Book</button>
        </form>
    </div>
</div>



</body>
</html>
