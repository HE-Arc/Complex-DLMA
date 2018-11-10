// Everything inside this bloc is charged when the document is ready
$(document).ready(function ()
{
    let userHasVoted = false;

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
        let userID = parseInt($('#userID').html());
        let questionID = parseInt($('#questionID').html());

        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });
      
        $.ajax({
            url: 'increment_counter',
            type: 'POST',
            data: 'choiceID=' + (choiceID - 1) + "&userID=" + userID + "&questionID=" + questionID,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    };

});