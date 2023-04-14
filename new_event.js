function eventType(event)
{
    // if (event.value == "public")
    // {
    //     document.getElementById("chose_public_event").style.display = "block";
    //     document.getElementById("chose_private_event").style.display = "none";
    //     document.getElementById("chose_rso_event").style.display = "none";
    // }
    // else 
    // if (event.value == "private")
    // {
    //     // document.getElementById("chose_public_event").style.display = "none";
    //     document.getElementById("chose_private_event").style.display = "block";
    //     document.getElementById("chose_rso_event").style.display = "none";
    // }
    // else 
    if (event.value == "rso")
    {
        // document.getElementById("chose_public_event").style.display = "none";
        // document.getElementById("chose_private_event").style.display = "none";
        document.getElementById("chose_rso_event").style.display = "block";
    }
    else
    {
        // document.getElementById("chose_public_event").style.display = "none";
        // document.getElementById("chose_private_event").style.display = "none";
        document.getElementById("chose_rso_event").style.display = "none";
    }
}

function displayJoinRso()
{
    // alert("join button clicked");
    document.getElementById("join_rso_button").style.display = "none";
    document.getElementById("leave_rso_button").style.display = "block";
    document.getElementById("join_rso_form").style.display = "block";
    document.getElementById("leave_rso_form").style.display = "none";
}

function displayLeaveRso()
{
    // alert("leave button clicked");
    document.getElementById("join_rso_button").style.display = "block";
    document.getElementById("leave_rso_button").style.display = "none";
    document.getElementById("join_rso_form").style.display = "none";
    document.getElementById("leave_rso_form").style.display = "block";
}