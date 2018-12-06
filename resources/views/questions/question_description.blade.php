<div class="col-12">
    @if ($data['question_description'] == "")

    <div class="col-12 cd_medium-text font-weight-bold">
        No description provided !
    </div>

    @else

    <div class="col-12 cd_medium-text font-weight-bold">
        Description
    </div>
    
    <div class="col-12 cd_medium-text">
        {{ $data['question_description'] }}
    </div>
    
    @endif
</div>