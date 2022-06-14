<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <title>Book update</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('books.update', ['id' => $book->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
				{{ method_field('PUT') }}
                    <table class="table table-striped table-border">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">title</th>
                            <th scope="col">description</th>
                            <th scope="col">Author</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Status</th>
                            <th scope="col">Assignee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">{{ $book->id }}</th>
                            
                            <td>
                                <input type="text" name="title" value="{{ $book->title }}" >
                            </td>

                            <td>
                                <input type="text" name="description" value="{{ $book->description }}" >
                            </td>
                            
                            <td>
                                <input type="text" name="author" value="{{ $book->author }}" >
                            </td>

                            <td>
                                <input type="number" name="owner" value="{{ $book->owner }}" >
                            </td>

                            <td>
                                <select name="status" class="form-select">
                                    @if($book->status == 0)
                                    <option selected value=0>available</option>
                                    <option value=1>borrowing</option>
                                    <option value=2>not available</option>
                                    @elseif($book->status == 1)
                                    <option value=0>available</option>
                                    <option selected value=1>borrowing</option>
                                    <option value=2>not available</option>
                                    @elseif($book->status == 2)
                                    <option value=0>available</option>
                                    <option value=1>borrowing</option>
                                    <option selected value=2>not available</option>
                                    @endif
                                </select>
                            </td>

                            <td>
                                <input type="number" name="assignee" value="{{ $book->assignee }}" >
                            </td>
                        </tr>
                        </tbody>
                    
                    </table>

                    <div class="form-group justify-content">
					    <input type="submit" value="UPDATE">
				    </div>
                </form>
                <div class="d-flex justify-content-center">
                </div>
            </div>
        </div>
    </div>
</body>
<style>
    .table-border {
        border: 1px solid blue;
    }

    .table td {
        border-left: 1px solid black;
    }
</style>
</html>