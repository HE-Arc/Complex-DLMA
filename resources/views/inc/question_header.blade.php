@php
$usernames = array();
foreach($data['usernames'] as $username)
{
    array_push($usernames, $username['username']);
}
@endphp

<script>
    var usernames = {!! json_encode($usernames) !!};
    var questionID = {!! json_encode($data['question']->id) !!};
    var questionDescription = {!! json_encode($data['question']->description) !!};
    var questionChoice1 = {!! json_encode($data['choice1Text']) !!};
    var questionChoice2 = {!! json_encode($data['choice2Text']) !!};
</script>