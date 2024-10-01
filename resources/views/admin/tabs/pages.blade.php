<div class="container my-3" id='new-page'>
    <p class="h3">New Page</p>
    <form action="{{ route('pages.store') }}" method='POST'>
        @csrf
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" maxlength="100" name="title" id="title" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
<div class="container my-3" id='page-list'>
    <p class="h3">Pages ({{$pages->count()}}/3 created)</p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($pages as $page)
            <tr>
                <th>
                    <a href="/pages/{{$page->slug}}">
                    {{ $page->title }}
                    </a>
                </th>
                <th>
                    <span id="delete-button">
                        <form action="{{ route('pages.destroy', $page) }}" method='POST'>
                            @csrf
                            @method('DELETE')
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePage-modal">
                                <i class="fas fa-trash"></i>
                            </button>
                            <!-- Modal component -->
                            <x-modal id="deletePage" type="danger" title="Confirm Page Deletion">
                                Are you sure you want to delete this page?
                            </x-modal>
                        </form>
                    </span>
                </th>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>