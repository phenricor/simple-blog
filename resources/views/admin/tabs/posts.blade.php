<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Comments</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr>
            <th class="align-middle" scope="row">{{ $post->id }}</th>
            <td class="align-middle">
                <a style="color:black;" href="{{ route('posts.show', $post->slug) }}">
                    {{ $post->title }}
                </a>
            </td>
            <td>{{ $post->created_at }}</td>
            <td>{{ $post->updated_at }}</td>
            <td class="align-middle">
                <a href="{{ route('posts.show', $post->slug) }}#comment-section">
                    {{ $post->comments->count() }}
                </a>
            </td>
            <td class="align-middle">
                <span id="delete-button">
                    <form action="{{ route('posts.destroy', $post) }}" method='POST'>
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="dashboard" name="dashboard" value="1">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePost-modal">
                            <i class="fas fa-trash"></i>
                        </button>
                        <!-- Modal component -->
                        <x-modal id="deletePost" type="danger" title="Confirm Post Deletion">
                            Are you sure you want to delete this post?
                        </x-modal>
                    </form>
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-xl-4 d-flex justify-content-center">
    {{ $posts->links("pagination::bootstrap-4") }}
</div>