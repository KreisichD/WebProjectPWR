<?php
include_once 'DBH.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Customize your account">
	<meta name="keywords" content="Code, tutorial, blog, feed, social, playground">
	<meta name="author" content="D & P">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>DB check</title>
	<link rel="stylesheet" type="text/css" href="MainLayout.css" />
	<style>
        table {
            background-color: lightgray;
            border: 1px solid gray;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            border: 1px solid gray;
        }

        tr:nth-child(even) {
            background-color: white;
        }

        tr:first-child {
            background-color: lightblue;
        }
    </style>
</head>
<?php 
include 'setBackground.php';
?>
	<div class="container">
		<header class="row">
			<a href="index.html"><div class="col8"><img src="MediaFiles/logo.png" alt="logo" /></div></a>
		</header>
		<nav class="row">
            <?php
            if (!isset($_SESSION['active'])) {
                echo "<div class=\"off7 col1 mtopbottom\" style=\"text-align:right;\"><a href=\"Register.html\">Register</a> or <a href=\"Login.html\">Login</a></div>";
            } else {
                echo "<div class=\"off7 col1 mtopbottom\" style=\"text-align:right;\"><a href=\"Logout.php\">Log out</a></div>";
            }
            ?>
            <div class="col2s hiddenMenu">
				<span class="col8s">Menu</span>
				<ul id="standardMenu" class="col8">
					<li><a href="index.html">News</a></li>
					<li><a href="CodeSite.html">Code Site</a></li>
					<li>
						Links
						<ol>
							<li><a href="https://stackoverflow.com/" target="_blank">Stack Overflow</a></li>
							<li><a href="https://github.com/KreisichD/WebProjectPWR" target="_blank">Our GitHub</a></li>
							<li><a href="#">Dev tools reviews</a></li>
						</ol>
					</li>
					<li><a href="AboutUs.html">About us</a></li>
					<li><a href="Contact.html">Contact</a></li>
				</ul>
			</div>
			<div class="menuoffs"></div>
		</nav>
        <div class="off1">
            <label>Filters:</label>
            <form method="post" action="checkDB.php">
                <label>First Name:</label>
                <input type="text" name="FirstName" size="10"/>

                <label>Last Name:</label>
                <input type="text" name="LastName" size="10"/>

                <label>Email:</label>
                <input type="text" name="E_mail" size="10"/>

                <label>Sex:</label>
                <input type="text" name="Sex" size="10"/>

                <br />

                <input type="submit" value="FILTER" />
                <input type="reset" value="RESET" />
            </form>
        </div>

		<div class="off1">
            <?php
            $query = "SELECT * FROM sysusers";

            if (!empty($_POST)) {
                $sep = " WHERE ";
                foreach($_POST as $name => $value) {
                    if ($value != "") {
                        $query = $query . $sep . $name . " LIKE('%" . $value . "%') ";
                        $sep = " AND ";
                    }
                }
                //echo "<p>$query</p>";
                //die();
            }

            if (!$conn)
                die("<p>DB error</p>");

            if (!$result = mysqli_query($conn, $query))
                die("<p>Query error</p>");

            ?>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Pass</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of birth</th>
                    <th>Sex</th>
                    <th>Phone Number</th>
                    <th>University</th>
                    <th>AboutMe</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_row($result)) {
                    print("<tr>");

                    foreach($row as $val)
                        print("<td>$val</td>");

                    print("</tr>");
                }
                mysqli_close($conn);
                ?>
            </table>
		</div>
		<footer class="row text-center">
			<img src="MediaFiles/logo.png" alt="logo_mini" width="15" height="15" /> D &amp; P &copy; 2018 D &amp; P. All rights reserved.
		</footer>
	</div>
</body>
</html>