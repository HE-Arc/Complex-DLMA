// Everything inside this bloc is charged when the document is ready
$(document).ready(function ()
{
    let userHasVoted = false;

    setUriQuestionID(questionID);
    
    $('#formComment').on('submit', function()
    {
        //https://stackoverflow.com/questions/27346205/submit-form-laravel-using-ajax
        var commentText = $('#commentText').val();
        userPostComment(commentText);
    });

    /**
     * When the user click on the button next question.
     * A new question is load from the db and is load in the page.
     */
    $('#nextQuestion').on('click', function()
    {
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            url: 'next_question',
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                updateChoices(data['question']);
                updateQuestionDetails(data['question']['id']);
                UpdateComments(data['question']['id']);
                setUriQuestionID(data['question']['id']);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });

    function setUriQuestionID(questionID)
    {
        history.pushState(null, "", "./" + questionID);
    }

    /**
     * Update the question username, description and comments
     * @param {array} data 
     */
    function updateQuestionDetails(questionID)
    {
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });
        
        $.ajax({
            url: 'next_question_header',
            type: 'GET',
            data: 'questionID=' + questionID,
            dataType: 'HTML',
            success: function (data) {
                $('#questionHeader').html(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });

        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });
        $.ajax({
            url: 'next_question_username',
            type: 'GET',
            data: 'questionID=' + questionID,
            dataType: 'HTML',
            success: function (data) {
                $('#questionUsername').html(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });

        $.ajax({
            url: 'next_question_description',
            type: 'GET',
            data: 'questionID=' + questionID,
            dataType: 'HTML',
            success: function (data) {
                $('#questionDescription').html(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    }

    function UpdateComments(questionID)
    {
        $.ajax({
            url: 'next_question_comments',
            type: 'GET',
            data: 'questionID=' + questionID,
            dataType: 'HTML',
            success: function (data) {
                $('#questionComments').html(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });

        $.ajax({
            url: 'next_question_comments_counter',
            type: 'GET',
            data: 'questionID=' + questionID,
            dataType: 'HTML',
            success: function (data) {
                $('#questionCommentsCounter').html(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    }

    /**
     * Update the 2 choices
     * @param {array} data
     */
    function updateChoices(choicesID)
    {
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            url: 'next_question_choice',
            type: 'GET',
            data: 'choiceID=' + choicesID['choice_1_id'],
            dataType: 'HTML',
            success: function (data) {
                $('#choice1').html(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
        
        $.ajax({
            url: 'next_question_choice',
            type: 'GET',
            data: 'choiceID=' + choicesID['choice_2_id'],
            dataType: 'HTML',
            success: function (data) {
                $('#choice2').html(data);

                userHasVoted = false;
                $('#checkedChoice1').addClass('d-none');
                $('#checkedChoice2').addClass('d-none');
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    }

    /**
     * When the user click on the button 1
     */
    $('#userChoice1').on('click', function()
    {
        userSelectChoice(1);
    });

    /**
     * When the user click on the button 2
     */
    $('#userChoice2').on('click', function()
    {
        userSelectChoice(2);
    });

    /*
    * We want to ask the user to login before he starts typing his long ramblings
    */
    $('#commentText').on('focus', function()
    {
        userCheckRedirectLogin();
    });

    $('#postComment').click(function(e)
    {   
        var commentText = $('#commentText').val().trim();
        if(commentText.length > 0)
            userPostComment(commentText);
    });

    /**
     * Is called when the user make a choice.
     * Display the votes number and the percentage of each choice.
     * Call a controller in ajax to increment the choice counter.
     * 
     * @param {int} choiceID : the id of the choice made by the user
     */
    function userSelectChoice(choiceID)
    {
        // Avoid voting twice
        if(userHasVoted)
        {
            return;
        }
        userHasVoted = true;

        // Declare and init var.
        let nbOfVotes = [];
        let choicesPercDOM = [];
        let choicesCounterDOM = [];

        $('#choicesMain .userChoice').each(function()
        {
            nbOfVotes.push(parseInt($(this).find('.initVotes').html()));
            choicesPercDOM.push($(this).find('.cd_choice-perc'));
            choicesCounterDOM.push($(this).find('.cd_choice-counter'));
        });

        // Compute the votes percentage
        nbOfVotes[choiceID - 1]++;

        nbOfVotesTot = nbOfVotes.reduce((x, y) => x + y);

        choicesPerc = [];
        choicesPerc.push(Math.round(nbOfVotes[0] / nbOfVotesTot * 100));
        choicesPerc.push(Math.round(nbOfVotes[1] / nbOfVotesTot * 100));

        // Display the votes and the percentage for each question
        let i = 0;
        $.each(choicesPercDOM, function()
        {
            $(this).removeClass('d-none');
            $(this).html(choicesPerc[i] + "%");
            i++;
        });

        i = 0;
        $.each(choicesCounterDOM, function()
        {
            $(this).removeClass('d-none');
            $(this).html(nbOfVotes[i] + " votes");
            i++;
        });
        
        $('#checkedChoice' + choiceID).removeClass('d-none');

        // Ajax request to increment the user choice
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });
      
        $.ajax({
            url: 'dispatch_request',
            type: 'POST',
            data: 'choiceID=' + (choiceID - 1),
            dataType: 'HTML',
            success: function (data) {
                //console.log(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    };


    /**
     * This verifies that the user is indeed logged in before posting a comment
     */
    function userCheckRedirectLogin()
    {
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });
      
        $.ajax({
            url: 'auth/check',
            type: 'GET',
            success: function (userID) {
                if(userID == "")
                    window.location.href = "login";
            },
        });
    }

    function userPostComment(commentText)
    {
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });

        $.ajax({
            url: 'post_comment',
            type: 'POST',
            data: 'commentText=' + commentText,
            dateType: 'HTML',
            success: function (data) {
                console.log(data);
                console.log(questionID);
                UpdateComments(questionID);
                $('#commentText').val('');
            },
            error: function (e) {
                console.log("error");
            }
        });
    };

});