 
var q = 0;
function stamp(){
    var date = new Date(); //DATE
    var zone = date.getTimezoneOffset();   //OFFSET FOR THIS SERVER (VARIES DEPENDING ON TIME ZONE)
    var offset = 420;
    //DIFFERENCE OF SERVER TIME ZONE & CLIENT TIME ZONE
        var doz = offset-zone;
    //CONVERTS THE MINUTES TO SECONDS
    var sec = (doz*60);

    //MAKES THE CLIENT TIMESTAMP MATCH THE SERVER TIMESTAMP
    if(zone>offset){ //IF CLIENT TZ IS BEHIND OF THE SERVER'S TZ
        stamp += sec; //CLIENTS TIMESTAMP INCREASES TO MATCH THE SERVER'S
    }
    if(zone<offset){ //IF CLIENT TZ IS AHEAD OF THE SERVER'S TZ
        stamp -= sec; //CLIENTS TIMESTAMP DECREASES TO MATCH THE SERVER'S
    }

    //CONVERS THE DIFFERENCE BETWEEN NOW & THEN TO THE GREATEST UNIT OF TIME
    $('.stamp').each(function(){
        //TIMESTAMP HIDDEN IN EACH "<span>" 'id' ATTRIBUTE
        var s = parseInt($(this).attr('id').substr(1));
     var diff = stamp-s; //DIFFERENCE BETWEEN POSTED TIMESTAMP & CURRENT TIMESTAMP

        if (diff < 60){
            var count = diff;
            if (count==0)
            count = "a moment";
            else if (count==1)
            var suffix = "second";
            else
            var suffix = "seconds";
        }
        if (diff >= 60 && diff < 3600){
            var count = Math.floor(diff/60); if (count==1)
            var suffix = "minute";
            else
            var suffix = "minutes";
        }

        if (diff >= 3600 && diff < 86400){
            var count = Math.floor(diff/3600);
            if (count==1)
            var suffix = "hour";
            else
            var suffix = "hours";
        }

        if (diff >= 86400 && diff < 60*60*24*7){
            var count = Math.floor(diff/86400);
            if (count==1)
            var suffix = "day";
            else
            var suffix = "days";
        }

        if (diff >= 60*60*24*7 && diff < 60*60*24*30){
            var count = Math.floor(diff/(60*60*24*7));
            if (count==1)
            var suffix = "week";
            else
            var suffix = "weeks";
        }

        if (diff >= 60*60*24*30&& diff < 60*60*24*365){
            var count = Math.floor(diff/(60*60*24*30));
            if (count==1)
            var suffix = "month";
            else
            var suffix = "months";
        }

        if (diff >= 60*60*24*365){
            var count = Math.floor(diff/(60*60*24*365));
            if (count==1)
            var suffix = "year";
            else
            var suffix = "years";
        }
        $(this).html(count+' '+suffix+' ago');
    });

    //PREVENTS THE "FIRST SECOND" DELAY
    if(q==0){
        setTimeout("stamp()", 0);
    } else {
        setTimeout("stamp()", 1000);
    }
    q++;
}
stamp(); //STARTS & REPEATS THE FUNCTION
function c(){
    var comment = $('#comment').val(); //COMMENT FROM <textarea>

    //POSTS COMMENT ONTO YOUR DATABASE
    $.ajax({
        type: 'POST',
        url: 'post-comment.php',
        data: 'comment='+comment,
        success: function(e){
            if(e){
                $('#m').html('Error Posting');
            } else {
                $('#comments').load('message.php'); //REFRESHES THE CURRENT LIST OF COMMENTS
            }
        }
    });
}