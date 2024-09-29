<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Email</th>
            <th scope="col">Name</th>
            <th scope="col">Content</th>
            <th scope="col">Post</th>
            <th scope="col">Created At</th>
            <th scope="col">Updated At</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($comments as $comment)
        <tr>
            <th class="align-middle" scope="row">{{ $comment->id }}</th>
            <td class="align-middle">{{ $comment->email }}</td>
            <td>{{ $comment->name }}</td>
            <td>{{ $comment->content }}</td>
            <td>
                @if ($comment->post)
                <a href="{{ route('posts.show', $comment->post->slug) }}">
                    {{ $comment->post->title }}
                </a>
                @else
                <a>Missing</a>
                @endif
            </td>
            <td>{{ $comment->created_at }}</td>
            <td>{{ $comment->updated_at }}</td>
            <td id="status-{{$comment->id}}">
                <p class="{{ $comment->statusColor() }}">{{ $comment->statusString() }}</p>
            </td>
            <td>
                <div class="d-flex justify-content-between" style="gap:6px">
                    <!-- To do approve comment -->
                     @if ($comment->post !== null && $comment->status === 0)
                    <span id="approve-button">
                        <button class="btn btn-success btn-sm" onclick="updateField( {{ $comment->id }} )" type="button">
                            <i class="fa-solid fa-thumbs-up"></i>
                        </button>
                    </span>
                    @endif
                    <span id="delete-button">
                        <form action="{{ route('comments.destroy', $comment) }}" method='POST'>
                            @csrf
                            @method('DELETE')
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteComment-modal">
                                <i class="fas fa-trash"></i>
                            </button>
                            <!-- Modal component -->
                            <x-modal id="deleteComment" type="danger" title="Confirm Comment Deletion">
                                Are you sure you want to delete this comment?
                            </x-modal>
                        </form>
                    </span>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-xl-4 d-flex justify-content-center">
    {{ $comments->links("pagination::bootstrap-4") }}
</div>
<script>
    function updateField(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "../approveComment", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("Field updated successfully");

            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                document.getElementById('status-' + id).innerText = "Approved";
            }
        }
    };

    xhr.send(JSON.stringify({
        id: id,
    }));
}
</script>