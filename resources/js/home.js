// Everything inside this bloc is charged when the document is ready
$(document).ready(function ()
{
    let userHasVoted = false;

    /**
     * When the user click on the translation button
     */
    $('.userChoice').on('click', function()
    {
        // Avoid voting twice
        if(userHasVoted)
        {
            return;
        }
        userHasVoted = true;

        // Get necessary DOM elements
        let button = $(this);
        let choiceNum = button.data('choice');
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
        nbOfVotes[choiceNum - 1]++;

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
        
        $('#choicesMain #checkedChoice' + choiceNum).removeClass('d-none');

        // Ajax request to increment the user choice
        $.ajaxSetup({
            headers: {"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')}
        });
      
        $.ajax({
            url: 'increment_counter',
            type: 'POST',
            data: 'choiceNum=' + choiceNum,
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
            },
            error: function (e) {
                console.log(e.responseText);
            }
        });
    });

});