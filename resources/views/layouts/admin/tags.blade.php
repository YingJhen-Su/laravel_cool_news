<!-- Side widgets-->
<div class="col-lg-4">
    <!-- Tags widget-->
    <div class="card mb-4">
        <div class="card-header">Tags</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <ul class="list-unstyled mb-0">
                        @foreach($tagUseds as $tagUsed)
                            <li><a href="/admin/tags/{{ $tagUsed->id }}">{{ $tagUsed->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>