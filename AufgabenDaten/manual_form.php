<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Form</title>
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["firstname"])) {
        $firstname = stripString($_POST["firstname"]);
    }

    if (isset($_POST["lastname"])) {
        $lastname = stripString($_POST["lastname"]);
    }

    if (isset($_POST["email"])) {
        $email = stripString($_POST["email"]);
    }

}

function stripString($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Vorname: <input type="text" name="firstname" required="required" value="<?php echo (isset($firstname)) ? $firstname : ""; ?>">
    <br><br>
    Nachname: <input type="text" name="lastname" value="<?php echo (isset($lastname)) ? $lastname : ""; ?>">
    <br><br>
    Email: <input type="text" name="email" value="<?php echo (isset($email)) ? $email : ""; ?>">
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>
</body>
</html>