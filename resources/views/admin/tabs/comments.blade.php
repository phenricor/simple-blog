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
            <th id="comment-{{ $comment->id }}" class="align-middle" scope="row">{{ $comment->id }}</th>
            <td class="align-middle">{{ $comment->email }}</td>
            <td class="align-middle">{{ $comment->name }}</td>
            <td class="align-middle">{{ $comment->content }}</td>
            <td class="align-middle">
                @if ($comment->post)
                <a href="{{ route('posts.show', $comment->post->slug) }}">
                    {{ $comment->post->title }}
                </a>
                @else
                <a>Missing</a>
                @endif
            </td>
            <td class="align-middle">{{ date_format($comment->created_at, "Y/m/d H:i:s") }}</td>
            <td class="align-middle">{{ date_format($comment->updated_at, "Y/m/d H:i:s") }}</td>
            <td class="align-middle" id="status-{{$comment->id}}">
                <p>{{ $comment->statusString() }}</p>
            </td>
            <td class="align-middle">
                <div class="d-flex justify-content-between" style="gap:6px" id="action-buttons-{{ $comment->id }}">
                     @if ($comment->post !== null && $comment->status === 0)
                    <span>
                        <button class="btn btn-success btn-sm" onclick="approveComment({{ $comment->id }})" type="button" id="approveComment-{{$comment->id}}">
                            <i class="fa-solid fa-thumbs-up"></i>
                        </button>
                    </span>
                    <span>
                        <button class="btn btn-danger btn-sm" onclick="disapproveComment({{ $comment->id }})" type="button" id="disapproveComment-{{$comment->id}}">
                            <i class="fa-solid fa-thumbs-down"></i>
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
    function approveComment(id) {
        fetch(`/comments/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#status-${id} p`).innerText = 'Approved';
            }
        })
    }

    function disapproveComment(id) {
        fetch(`/comments/${id}/disapprove`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#status-${id} p`).innerText = 'Disapproved';
            }
        })
    }
</script>
