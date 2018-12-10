@php
$innerUsernames = [];
foreach($usernames as $username)
{
    array_push($innerUsernames, $username->username);
}
@endphp

<script>
    var usernames = {!! json_encode($innerUsernames) !!};
    var questionID = {!! json_encode($id) !!};
    var questionDescription = {!! json_encode($description) !!};
    questionDescription = !questionDescription ? "" : questionDescription;
    var questionChoice1 = {!! json_encode($choice1Text) !!};
    var questionChoice2 = {!! json_encode($choice2Text) !!};
</script>