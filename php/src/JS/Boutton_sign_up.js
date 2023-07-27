// get the number of players required for the tournament
function get_nb_player_select() {
    var nb_player = document.getElementById('nb_player').innerText;
    nb_player = nb_player.substring(14, 16);
    return parseInt(nb_player);
}

//check if the nb of player checked is equal to the number of player needed
// for the cup
function get_player_from_team() {
    var bool = false;
    var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    nb_player = get_nb_player_select();
    if (nb_player == checkboxes.length) {
        bool = true;
    }
    print_button(bool);
}

//print the button if the number of checked playeris true
function print_button(bool) {
    if (bool) {
        document.getElementById('button_team_select').style.display = 'block';
    } else {
        document.getElementById('button_team_select').style.display = 'none';

    }
}

