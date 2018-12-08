// Everything inside this bloc is charged when the document is ready
$(document).ready(function ()
{
    let userHasVoted = false;
    
    nextQuestion(questionID);

    /**
     * Load a new question or the one corresponding with the given question id.
     * Update the DOM with the received values.
     * 
     * @param {Integer} questionID : The id of the question to load, null if a new question should be load.
     */
    function nextQuestion(questionID)
    {
        $('.cd_fade-choices').removeClass('cd_swap-next-question-in');
        $('.cd_fade-choices').removeClass('cd_swap-next-question-out');
        $('.cd_fade-choices').addClass('cd_swap-next-question-out');

        $('.cd_logo-big').removeClass('cd_swap-next-question-in');
        $('.cd_logo-big').removeClass('cd_swap-next-question-out');
        $('.cd_logo-big').addClass('cd_swap-next-question-in');

        if (questionID === null)
        {
            $.ajax({
                url: 'next_question',
                type: 'GET',
                dataType: 'JSON',
                success: function (data) {
                    fillDomWithContent(data);
                },
                error: function (e) {
                    console.log("ERROR");
                }
            });
        }
        else
        {
            $.ajax({
                url: 'specific_question',
                type: 'GET',
                data: 'questionID=' + questionID,
                dataType: 'JSON',
                success: function (data) {
                    fillDomWithContent(data);
                },
                error: function (e) {
                    console.log("ERROR");
                }
            });
        }
    }

    /**
     * Update the DOM with the given values.
     * 
     * @param {Array} data : contains partial views (html)
     */
    function fillDomWithContent(data)
    {
        $('#questionHeader').html(data['header']);
        $('#choice1').html(data['choice1']);
        $('#choice2').html(data['choice2']);
        $('#questionUsername').html(data['username']);
        $('#questionDescription').html(data['description']);
        $('#questionComments').html(data['comments']);
        $('#questionCommentsCounter').html(data['comments_number']);

        setUriQuestionID(questionID);

        // Fade question
        $('.cd_fade-choices').addClass('cd_swap-next-question-in');
        $('.cd_logo-choices').removeClass('cd_swap-next-question-in');

        $('.cd_logo-big').addClass('cd_swap-next-question-out');
        $('.cd_logo-big').removeClass('cd_swap-next-question-in');

        // Display the checker for the checked choice
        userHasVoted = false;
        $('#checkedChoice1').addClass('d-none');
        $('#checkedChoice2').addClass('d-none');
    }

    /**
     * When the user click on the button next question.
     * A new question is load from the db and is load in the page.
     */
    $('#nextQuestion').on('click', function()
    {
        nextQuestion(null);
    });

    /**
     * Update the URI with the current question id.
     */
    function setUriQuestionID(questionID)
    {
        history.pushState(null, "", "./" + questionID);
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
                console.log("ERROR");
            }
        });
    };

    /**
     * This verifies that the user is indeed logged in before posting a comment
     */
    function userCheckRedirectLogin()
    {      
        $.ajax({
            url: 'auth/check',
            type: 'GET',
            success: function (userID) {
                if(userID == "")
                {
                    var loc = "login?previous=/" + questionID;
                    console.log(loc);
                    window.location.href = loc;
                }
            },
        });
    }

    /**
     * Update the DB with the the user comment and update the required part of the DOM.
     * 
     * @param {String} commentText : The comment
     */
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
                $('#commentText').val('');
                $('#questionComments').html(data['comments']);
                $('#questionCommentsCounter').html(data['comments_number']);
            },
            error: function (e) {
                console.log("ERROR");
            }
        });
    };
});