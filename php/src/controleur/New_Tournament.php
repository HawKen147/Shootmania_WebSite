<?php

use function PHPSTORM_META\type;

 if(!isset($_SESSION)){
    session_start();
}
include("action.php");

///////////////////////////////////////////////////////////////////////////
//////////////////  Crate a new Tournament  ///////////////////////////////
///////////////////////////////////////////////////////////////////////////

if (isset($_POST['Tournament_Name']) && isset($_POST['Tournament_Desc']) && isset($_POST['Tournament_mode'])){
    $Name = htmlspecialchars($_POST['Tournament_Name']);
    $Desc = htmlspecialchars($_POST['Tournament_Desc']);
    $Nb_player = htmlspecialchars($_POST['Tournament_nb_player']);
    $Mode = htmlspecialchars($_POST['Tournament_mode']);
    $Image = htmlspecialchars($_POST['Image_Tournament']);
    $Date = htmlspecialchars($_POST['time']);
    //var_dump($Date);
    $Serv = htmlspecialchars($_POST['Serv_Link']);
    $Createur = htmlspecialchars($_SESSION["utilisateur"]);
    
    #transform the date from y-m-d to d-m-y
    $Date = explode('T', $Date);
    $date_tab_0 = replace_char_by_space($Date[0]);
    $date_hours_tab = $Date[1];
    $date_hours_tab = replace_char_by_space($date_hours_tab);
    $date_tab_0 = explode(' ', $date_tab_0);
    $Date = date_in_good_order($date_tab_0, $date_hours_tab);
    
    #prepare the sql request
    if ($Image ==''){
        $Image = "https://www.aht.li/3715849/shootmania_banniere.png";
    }
    if (Create_Tournament($Name, $Desc,$Nb_player, $Mode, $Image, $Date, $Serv, $Createur) == true){
        $Name_table = replace_char_by_($Name); // replace every special char by _ if not doesn't work for the sql request
        create_table_tournament_playable($Nb_player,$Name_table,$Name);
        $_SESSION["tournament"] = true;
        header('Location:/view/home.php');
    }  else {
        $_SESSION["tournament"] = false;
        header('Location:/view/home.php');
    }
}


function replace_char_by_($string){
    $string = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), '_', $string);
    return $string;
}

function replace_char_by_space($string){
    $string = str_replace(str_split('# :/;.,?&~"{(-|è`_\'ç^à@)]°=+}*µ$£¨ù%§<>%ù'), ' ', $string);
    return $string;
}

function date_in_good_order ($array1, $string){
    $year = $array1[0];
    $day = $array1[2];
    $tmp = $year;
    $array1[0] = $day;
    $array1[2] = $tmp;
    $array1[3] = $string;
    $string = implode(' ',$array1);
    return $string;
}
