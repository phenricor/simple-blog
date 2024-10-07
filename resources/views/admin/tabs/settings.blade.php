<div id="error-messages" style="display:none" class="alert alert-danger"></div>

<p class="h2">Social Media Links</p>
<p style="color:gray">Double click on links to insert or change url to each social media.</p>
<table class="table table-striped">
    <thead>
        <th scope="col" style="width:250px">Social Media</th>
        <th scope="col">Link</th>
    </thead>
    <tbody>
        @foreach($settings->where('type', 'social_media') as $socialMediaSetting)
        <tr>
            <td style="width:250px; height: 50px" class="align-middle">{{ $socialMediaSetting->key }}</td>
            <td style="height: 50px" class="align-middle" id="container-{{ $socialMediaSetting->key }}">
                <span data-toggle="tooltip" data-placement="ontop" title="Double click to insert or change link." id="social-media-{{ $socialMediaSetting->key }}" ondblclick="editMode('{{$socialMediaSetting->key}}')">
                    @if ($socialMediaSetting->value !== null)
                    {{ $socialMediaSetting->value }}
                    @else
                    No link defined.
                    @endif
                </span>
                <span>
                    <input type="text" style="display:none; width:50%" id="input-{{$socialMediaSetting->key}}" value="{{$socialMediaSetting->value}}"></input>
                    <button class="button button-success" onclick="update('{{$socialMediaSetting->key}}')" style="display:none" id="check-{{$socialMediaSetting->key}}">
                        <i class="fa-solid fa-check"></i>
                    </button>
                    <button class="button button-secondary" onclick="editMode('{{$socialMediaSetting->key}}')" style="display:none" id="close-{{$socialMediaSetting->key}}">
                        <i class="fa-solid fa-x"></i>
                    </button>
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function editMode(key) {
        $("#social-media-" + key).toggle();
        $("#input-" + key).toggle();
        $("#check-" + key).toggle();
        $("#close-" + key).toggle();
    };

    function update(key) {
        let value = $('#input-' + key).val();
        let url = "../setting/" + key + "/update"
        $('#error-messages').html('').hide();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                value: value,
                key: key,
            },
            datatype: 'json',
            success: function() {
                editMode(key);
                $("#social-media-" + key).text(value);
                $('#error-messages').html('').hide();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorList = '<ul>';

                $.each(errors, function(key, value) {
                    errorList += '<li>' + value[0] + '</li>';
                });

                errorList += '</ul>';

                $('#error-messages').html(errorList).show();

            }
        })
    }
</script>