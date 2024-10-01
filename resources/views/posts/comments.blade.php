<!-- New comment form -->
<div class="container my-4">
    <p class="h4">Leave a comment</p>
    <div class="card px-4 py-4" id="add-comment-section">
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div id="content-box" class="my-0">
                <label class="fw-bold" for="content">Message</label>
                <textarea maxlength="255" rows='5' name="content" id="content" class="form-control" aria-label="With textarea"></textarea>
            </div>
            <div id="name-box" class="my-2">
                <div>
                    <label class="fw-bold" for="name">Name</label>
                </div>
                <input placeholder="Your name" maxlength="60" class="form-control" type="text" name="name" id="name" required>
            </div>
            <div id="email-box" class="my-2">
                <div>
                    <label class="fw-bold" for="email">Email</label>
                </div>
                <input placeholder="Your e-mail" maxlength="60" class="form-control" type="email" name="email" id="email" required>
            </div>
            <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
            <button type="submit" class="mt-3 btn btn-outline-dark">Submit comment</button>
        </form>
    </div>
    <!-- Comment section -->
    <div class="my-3">
        <p class="h4">Comments</p>
        @if(Auth::check()) <!-- Auth Check -->
        @if($allComments->count() <= 0) <!-- Comment count -->
            <p>No comments found</p>
            @else
            @foreach ($allComments as $comment)
            <div class="card my-3">
                <div class="card-header">
                    <span class="fw-bold">{{ $comment->name }}</span>
                    <span style="font-size:10px">{{ $comment->created_at }} </span>
                    <span class="{{ $comment->statusColor() }}">{{ $comment->statusString() }}</span>
                </div>
                <div class="container card-body">
                    <div class="row">
                        <div class="col d-flex align-items-top">
                            <img src="{{ asset('avatar.jpg') }}" style="border-radius:50px; width:25px; height:25px">
                        </div>
                        <div class="col-11 ps-1">
                            <p>{{ $comment->content}}</p>
                            <form action="{{ route('comments.destroy', $comment) }}" method='POST'>
                                @csrf
                                @method('DELETE')
                                <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#postDelete-modal">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <!-- Modal component -->
                                <x-modal id="postDelete" type="danger" title="Confirm Comment Deletion">
                                    Are you sure you want to delete this comment?
                                </x-modal>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif <!-- End comment count -->
            @else <!-- Not Auth Check -->
            @if ($approvedComments->count() <=0) <!-- Approved comments count -->
                <p>No comments yet</p>
                @else
                @foreach ($approvedComments as $approvedComment)
                <div class="card my-3">
                    <div class="card-header">
                        <span class="fw-bold">{{ $approvedComment->name }}</span>
                        <span style="font-size:10px">{{ $approvedComment->created_at }} </span>
                    </div>
                    <div class="container card-body">
                        <div class="row">
                            <div class="col d-flex align-items-top">
                                <img src="{{ asset('avatar.jpg') }}" style="border-radius:50px; width:25px; height:25px">
                            </div>
                            <div class="col-11 ps-1">
                                <p>{{ $approvedComment->content}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif <!-- End approved comments count -->
                @endif <!-- End Auth Check -->
    </div>