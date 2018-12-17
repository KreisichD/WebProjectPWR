<?php
$empty = false;
if (!empty($_POST)){
    $f_name =       $_POST["f_name"];
    $l_name =       $_POST["l_name"];
    $date_d =       $_POST["d_date"];
    $date_m =       $_POST["m_date"];
    $date_y =       $_POST["y_date"];
    $sex =          $_POST["sex"];
    $e_mail =       $_POST["mail"];
    $phone =        $_POST["phone"];
    $university =   $_POST["university"];
    $about =        $_POST["about"];
    if (!empty($_POST["lang"]))
        $langs =    $_POST["lang"];
}
else{
    $empty = true;
}
function verifyFirstName($fsname){
    return (preg_match("/\s|\W|\d/" ,$fsname));
}
function verifyLastName($nsname){
    return (preg_match("/\s|[_;':,.}{[]]|\d/" ,$nsname));
}
function verifyDay($day, $month, $year){
    if ($month == "February"){
        return $day>28;
    }
    if (in_array($month, ["April", "June", "September", "November"])){
        return $day>30;
    }
    return $day>31;
}
function verifyEMail($semail){
    return !((preg_match("/[@]/", $semail)) and (preg_match("/[.]/", $semail)));
}
function verifyPhone($phonenr){
    return (preg_match("/[^0-9]/",$phonenr));
}
function verifyPostedData(){
    $result = "";
    if (empty($_POST)){
        return ("<div class='off1 col3'>Please fill the register form</div>"."<div class='col4'><a href='/site/Register.html'>Register</a></div>");
    }
    if (verifyFirstName($GLOBALS['f_name'])){
        $result=$result."Please put there a legal first name (no spaces and numbers), legal digits(a-z '-') <br />";
    }
    if (verifyLastName($GLOBALS['l_name'])){
        $result=$result."Please put there a legal last name (no spaces and numbers), legal digits(a-z '-') <br />";
    }
    if (verifyDay($GLOBALS['date_d'], $GLOBALS['date_m'], $GLOBALS['date_y'])){
        $result=$result."There is no such day in this month/year <br />";
    }
    if (verifyEMail($GLOBALS['e_mail'])){
        $result=$result."E-Mail should be like 'example@gmail.com <br />";
    }
    if (verifyPhone($GLOBALS['phone'])){
        $result=$result."Phone should have a nine-digits <br />";
    }
    if ($result==""){
        $result="Given data is valid <br />";
    }
    return $result;
}
function iSeeThatYouLike(){
    $result = "I can see that you know ";
    if (isset($GLOBALS['langs'])){
        $langs = $GLOBALS['langs'];
        foreach ($langs as &$veal){
            $result = $result.$veal.'|';
        }
        $result = $result." that's amazing";
    }
    else{
        $result = $result."nothing";
    }
    echo $result."<br />";
}
function addUserToDatabase(){

}
?>