<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Comments</th>
            <th scope="col">Scheduled To</th>
            <th scope="col">Published?</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
        <tr id="post-{{ $post->id }}">
            <th class="align-middle" scope="row">{{ $post->id }}</th>
            <td class="align-middle">
                <a style="color:black;" href="{{ route('posts.show', $post->slug) }}">
                    {{ $post->title }}
                </a>
            </td>
            <td>{{ date_format($post->created_at, "Y-m-d H:i:s") }}</td>
            <td>{{ date_format($post->updated_at, "Y-m-d H:i:s") }}</td>
            <td class="align-middle">
                <a href="{{ route('posts.show', $post->slug) }}#comment-section">
                    {{ $post->countAllComments() }}
                </a>
            </td>
            <td class="align-middle" scope="row">{{ $post->scheduled_to }}</td>
            <td class="align-middle" scope="row">{{ ($post->published == 1) ? "True" : "False" }}</td>
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
                @if ($post->published == 0)
                <span>
                    <button type="button" class="btn btn-warning btn-sm" id="fastfoward" data-bs-toggle="modal" data-bs-target="#confirmFastFoward-modal" onclick="updatePublished({{ $post->id }})">
                        <i style="color:white" class="fas fa-plane"></i>
                    </button>
                        <!-- Modal component -->
                        <x-modal id="confirmFastFoward" type="warning" title="Confirm Post Fast Fowarding">
                            Are you sure you want to publish this post now?
                        </x-modal>
                </span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-xl-4 d-flex justify-content-center">
    {{ $posts->links("pagination::bootstrap-4") }}
</div>
<script>
    // TO DO: AJAX CALL TO UPDATE PUBLISHED STTATUS WHEN CLICK FAST FOWARD BUTTON
function updatePublished(id) {
    $("#btn-submit-confirmFastFoward").click(function() {
        fetch(`/posts/${id}/setPublishedTrue`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(function () {
            loadView()
        });
    });
}
</script>
