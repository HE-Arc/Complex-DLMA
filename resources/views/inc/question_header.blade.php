<script>
    var usernames = {!! json_encode($data['usernames']) !!};
    var questionID = {!! json_encode($data['question']->id) !!};
    var questionDescription = {!! json_encode($data['question']->description) !!};
    var questionChoice1 = {!! json_encode($data['choice1Text']) !!};
    var questionChoice2 = {!! json_encode($data['choice2Text']) !!};
</script>