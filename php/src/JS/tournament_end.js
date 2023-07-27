//check if the nb of player checked is equal to the number of player needed
// for the cup
function checkbox() {
    var checkbox = document.getElementById("no_winner");
    var checked = checkbox.checked;
    return checked;
}

//print the button / hide it
function print_button() {
    checked = checkbox();
    team = check_teams();
    if (checked && !team  || team == 2 && !checked) {
        document.getElementById('button_submit_end').style.display = 'block';
    } else {
        document.getElementById('button_submit_end').style.display = 'none';
    }
}

//check if there is 3 teams in the select and if they are differents
function check_teams(){
    var first_team = document.getElementById("Team_1st").value;
    var second_team = document.getElementById("Team_2nd").value;
    var third_team = document.getElementById("Team_3rd").value;
    if(first_team || second_team || third_team){
       var nb_teams = 1;
        if(first_team && second_team && third_team){
            if (first_team != second_team && first_team != third_team && second_team != third_team){
                var nb_teams = 2;
            }
        }
    }
    return nb_teams;
}