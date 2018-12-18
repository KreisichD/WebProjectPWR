<?php
include_once 'DBH.php';
?>

<!DOCTYPE html>
<html>
<head>
	<?php
	$verification = false;
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
	}
	else{
		die();
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
		,'.$uniid.','.'\''.$GLOBALS['about'].'\''.')';
        mysqli_query($conn, $query);
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
	?>

	<meta charset="utf-8" />
	<meta name="description" content="Informations about authors" />
	<meta name="keywords" content="Code, tutorial, blog, feed, social, playground" />
	<meta name="author" content="D & P" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="/site/MainLayout.css" />
	<title>User Created!</title>
</head>
<?php 
include 'setBackground.php';
?>
	<div class="container">
		<header class="row">
			<a href="/site/index.html">
				<div class="col8">
					<img src="/site/MediaFiles/logo.png" alt="logo" />
				</div>
			</a>
		</header>
		<nav class="row">
			<div class="off7 col1 mtopbottom">
				<a href="/site/Register.html">Register</a> or
				<a href="/site/Login.html">Login</a>
			</div>
			<div class="col2s hiddenMenu">
				<span class="col8s">Menu</span>
				<ul id="standardMenu" class="col8">
					<li>
						<a href="/site/index.html">News</a>
					</li>
					<li>
						<a href="/site/CodeSite.html">Code Site</a>
					</li>
					<li>
						Links
						<ol>
							<li>
								<a href="https://stackoverflow.com/" target="_blank">Stack Overflow</a>
							</li>
							<li>
								<a href="https://github.com/KreisichD/WebProjectPWR" target="_blank">Our GitHub</a>
							</li>
							<li>
								<a href="#">Dev tools reviews</a>
							</li>
						</ol>
					</li>
					<li>
						<a href="/site/AboutUs.html">About us</a>
					</li>
					<li>
						<a href="/site/Contact.html">Contact</a>
					</li>
				</ul>
			</div>
			<div class="menuoffs"></div>
		</nav>
		<div class="row">
			<div class="off1 col7">
				<?php		
				  print(verifyPostedData());

				  if ($GLOBALS['verification']){
					  addUserToDatabase();
				  }

				  mysqli_close($GLOBALS['conn']);
				?>
			</div>
			<!--<div class="off1 col7">
				Congratulations! You have created your own account!
			</div>
			<div class="off1 col7">
				You password is:
			</div>
							-->
		</div>
		<footer class="row text-center">
			<div class="col8 text-center">
				<img src="/site/MediaFiles/logo.png" alt="logo_mini" width="15" height="15" /> D &amp; P &copy; 2018 D &amp; P. All rights reserved.
			</div>
		</footer>
	</div>
</body>
</html>