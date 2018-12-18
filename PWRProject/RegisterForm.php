<?php
	include_once 'DBH.php';

	$verification;
	$completed;
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
		$pass =         $_POST["pass"];
		if (!empty($_POST["lang"]))
			$langs =    $_POST["lang"];

		$GLOBALS['completed'] = true;
        $GLOBALS['verification'] = false;
	}
	else{
		$GLOBALS['completed'] = false;
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
						$pass = $GLOBALS['pass'];
						$result="Given data is valid, your password is $pass <br />";
						$GLOBALS['verification'] = true;
					}
					return $result;
	}
	function getProgrammingLanguageId(){
		$conn = $GLOBALS['conn'];
		$result = "I can see that you know ";
		if (isset($GLOBALS['langs'])){
			$langs = $GLOBALS['langs'];
			$query = 'SELECT LangID FROM programminglanguages';
			$proglang = 'ProgLanguage = ';
			$separator = ' WHERE ';
			foreach ($langs as &$veal){
				$query = $query.$separator.$proglang.'\''.$veal.'\'';
				$separator = ' OR ';
			}
		}
		else{
				return NULL;
		}
		if (!$result = mysqli_query($conn, $query))
			return NULL;
		return $result;
	}
	function checkUniversity($university){
		$conn = $GLOBALS['conn'];

		$query = 'SELECT UniversityId FROM universities WHERE UniversityName = ';
		$query = $query.'\''.$university.'\'';
		if (!$result = mysqli_query($conn, $query) or mysqli_num_rows($result)<=0)
			return -1;

		$i = mysqli_fetch_assoc($result);

		return $i['UniversityId'];

	}
	function prepareDate(){
		$year = $GLOBALS['date_y'];
		$month = $GLOBALS['date_m'];
		$day = $GLOBALS['date_d'];
		$originalDate = $year.'-'.$month.'-'.$day;
		$newDate = new DateTime($originalDate);
		return $newDate->format('y-m-d');
	}
	function getUserId($mail){
		$conn = $GLOBALS['conn'];

		$query = 'SELECT UserID FROM sysusers WHERE E_mail = '.'\''.$mail.'\'';
		$result = mysqli_query($conn, $query);
		return mysqli_fetch_assoc($result)['UserID'];
	}
	function addUserToDatabase(){
		$conn = $GLOBALS['conn'];


		//checking university
		$university = $GLOBALS['university'];
		$uniid = checkUniversity($university);

		if ($uniid === -1){
			$query = 'INSERT INTO universities(UniversityId, UniversityName) VALUES (0,'.' \''.$university.'\''.')';
			mysqli_query($conn, $query);
			$uniid = checkUniversity($university);
		}
		//inserting user
		$date = prepareDate();
		$query = 'INSERT INTO sysusers
		(UserID, E_mail, UsrPass, FirstName, LastName, DateOfBirth, Sex, PhoneNr, University, AboutMe)
		VALUES (0, '.'\''.$GLOBALS['e_mail'].'\''.','.'\''.$GLOBALS['pass'].'\''.','.'\''.$GLOBALS['f_name'].'\''.'
		,'.'\''.$GLOBALS['l_name'].'\''.','.'\''.$date.'\''.','.'\''.$GLOBALS['sex'].'\''.','.'\''.$GLOBALS['phone'].'\''.'
		,'.$uniid.','.'\''.addslashes($GLOBALS['about']).'\''.')';
		mysqli_query($conn, $query);

        echo mysqli_error($conn);

		//inserting connections
		$userid = getUserId($GLOBALS['e_mail']);
		$result = getProgrammingLanguageId();
		if ($result != NULL){
			while($row = mysqli_fetch_row($result)){
				$query = 'INSERT INTO knownlangs(ProgLangID, UsrID) VALUES (';
				$query = $query.$row[0].', '.$userid.')';
				mysqli_query($conn, $query);
			}
		}
	}
    function updateUser(){
        $conn = $GLOBALS['conn'];

        //retrieving updated values
        $GLOBALS['f_name'] =       $_POST["f_name"];
		$GLOBALS['l_name'] =       $_POST["l_name"];
		$GLOBALS['date_d'] =       $_POST["d_date"];
		$GLOBALS['date_m'] =       $_POST["m_date"];
		$GLOBALS['date_y'] =       $_POST["y_date"];
		$GLOBALS['sex'] =          $_POST["sex"];
		$GLOBALS['e_mail'] =       $_POST["mail"];
		$GLOBALS['phone'] =        $_POST["phone"];
		$GLOBALS['university'] =   $_POST["university"];
		$GLOBALS['about'] =        $_POST["about"];
		$GLOBALS['pass'] =         $_POST["pass"];

		//checking university
		$university = $GLOBALS['university'];
		$uniid = checkUniversity($university);

		if ($uniid === -1){
			$query = 'INSERT INTO universities(UniversityId, UniversityName) VALUES (0,'.' \''.$university.'\''.')';
			mysqli_query($conn, $query);
			$uniid = checkUniversity($university);
		}
		//updating user
		$date = prepareDate();
		$query = 'UPDATE sysusers
		SET E_mail = '.'\''.quotemeta($GLOBALS['e_mail']).'\''.'
        , UsrPass = '.'\''.$GLOBALS['pass'].'\''.'
        , FirstName = '.'\''.$GLOBALS['f_name'].'\''.'
        , LastName = '.'\''.$GLOBALS['l_name'].'\''.'
        , DateOfBirth = '.'\''.$date.'\''.'
        , Sex = '.'\''.$GLOBALS['sex'].'\''.'
        , PhoneNr = '.'\''.$GLOBALS['phone'].'\''.'
        , University = '.'\''.$uniid.'\''.'
        , AboutMe = '.'\''.addslashes($GLOBALS['about']).'\''.'
        WHERE E_mail = '.'\''.quotemeta($_SESSION['login']).'\'';

		mysqli_query($conn, $query);

        echo mysqli_error($conn);

        $_SESSION['login'] = $GLOBALS['e_mail'];
    }
	function loadActualValues($usermail){
		$conn = $GLOBALS['conn'];
		$query = 'SELECT * FROM sysusers JOIN universities ON sysusers.University = universities.UniversityId WHERE E_mail = '.'\''.$usermail.'\'';
		$result = mysqli_query($conn, $query);
		$assoc = mysqli_fetch_assoc($result);
		$GLOBALS['f_name'] =       $assoc['FirstName'];
		$GLOBALS['l_name'] =       $assoc["LastName"];
		$GLOBALS['date_d'] =       date('j', strtotime($assoc["DateOfBirth"]));
		$GLOBALS['date_m'] =       date('n', strtotime($assoc["DateOfBirth"]));
		$GLOBALS['date_y'] =       date('Y', strtotime($assoc["DateOfBirth"]));
		$GLOBALS['sex']    =       $assoc["Sex"];
		$GLOBALS['e_mail'] =       $assoc["E_mail"];
		$GLOBALS['phone']  =       $assoc["PhoneNr"];
		$GLOBALS['university'] =   $assoc["UniversityName"];
		$GLOBALS['about'] =        $assoc["AboutMe"];
		$GLOBALS['pass']  =        $assoc["UsrPass"];
	}
	function setValue(&$value){
	if (!$GLOBALS['empty'])
		echo 'value="'.$value.'"';
	}
    function setMonth($month){
        if (isset($GLOBALS['date_m']))
            if ($GLOBALS['date_m'] == $month){
                echo 'selected';
            }
    }
    function setMale(){
        if ($GLOBALS['sex'] = 'male'){
            echo 'checked="checked"';
        }
        else{
            echo '';
        }

    }
    function setFemale(){
        if (isset($GLOBALS['sex']))
        {
        if ($GLOBALS['sex'] = 'Female'){
            echo 'checked="checked"';
        }
        else{
            echo '';
        }
        }
        else{
            echo 'checked="checked"';
        }
    }