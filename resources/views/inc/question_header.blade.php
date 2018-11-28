@php
$usernames = array();
foreach($data['usernames'] as $username)
{
    array_push($usernames, e($username['username']));
}
@endphp

<script>
    var usernames = {!! json_encode($usernames) !!};
    var questionID = {!! json_encode(e($data['question']->id)) !!};
    var questionTitle = {!! json_encode(e($data['question']->description)) !!};
    var questionChoice1 = {!! json_encode(e($data['choice1Text'])) !!};
    var questionChoice2 = {!! json_encode(e($data['choice2Text'])) !!};
    console.log(usernames);
    console.log(questionID);
    console.log(questionTitle);
    console.log(questionChoice1);
    console.log(questionChoice2);
</script>