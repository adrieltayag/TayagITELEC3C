<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

    <div class="card">
        <h3 class="card-header">Active Categories</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Category Image</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    @if ($category->trashed())
                        @continue
                    @endif
                    <tr>
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td> 
                                @if ($category->image)
                                <img src="{{ Storage::url('image/' . $category->image) }}" alt="Category Image" style="max-width: 100px;">
                            @else
                                NO IMAGE
                            @endif
                            </td>
                            <td>{{ $category->user_id }}</td>
                            <td>{{ $category->created_at->diffForHumans() }}</td>
                            <td>
                            <a href="{{ route('update.page', ['id' => $category->id]) }}" class="btn btn-info">Update</a><br>
                            <a style="margin-top:5px;" href="{{ route('softDelete.category', ['id' => $category->id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-4">
        <h3 class="card-header">Deleted Categories</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Category Image</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Deleted At</th>
                    <th scope="col">Actions</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    @if (!$category->trashed())
                        @continue
                    @endif
                    <tr>
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td> 
                            @if ($category->image)
                                <img src="{{ Storage::url('image/' . $category->image) }}" alt="Category Image" style="max-width: 100px;">
                            @else
                                NO IMAGE
                            @endif
                            </td>
                            <td>{{ $category->user_id }}</td>
                            <td>{{ $category->created_at->diffForHumans() }}</td>
                            <td>{{ $category->deleted_at->diffForHumans() }}</td>
                            <td>
                                <form method="POST" action="{{ route('restore.category', ['id' => $category->id]) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to restore this category?')">Restore</button>
                                </form>

                                <form method="POST" action="{{ route('forceDelete.category', ['id' => $category->id]) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button style="margin-top:5px;" type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to permanently delete this category?')">Permanently Delete</button>
                                </form>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="padding:15px;">
                            <form method="POST" action="{{ route('AllCat') }}" enctype="multipart/form-data">
                                @csrf 
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" required>
                                    <input type="file" name="image" required style="padding-top:5px;">
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>