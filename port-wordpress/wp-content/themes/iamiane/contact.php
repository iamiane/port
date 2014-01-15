<?php
/* Set e-mail recipient */
$myemail  = "ian@iamiane.co.uk";
$from = "portfolio";
$subject = "$subject";

/* Check all form inputs using check_input function */
$yourname = check_input($_POST['yourname'], "Enter your name");
$subject = check_input($_POST['subject']);
$email    = check_input($_POST['email']);
$comments = check_input($_POST['comments'], "Write your comments");


/* If e-mail is not valid show error message */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
    show_error("E-mail address not valid");
}



/* Let's prepare the message for the e-mail */
$message = 
"
Name: $yourname
E-mail: $email

Message:
$comments

End of message
";

$header1 = "From: \"$yourname $surname\" <$email>";
$header2 = "From: \"$from\" <$myemail>";

/* Send the message using mail() function */
mail($myemail, $subject, $message, $header1);


/* Redirect visitor to the thank you page */
header('Location: index.html');
exit();

/* Functions we used */
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
?>
    <html>
    <body>
    <b>Please correct the following error:</b>&nbsp;<?php echo $myError; ?>
    <br /><br />
	Click the back button to correct
    </body>
    </html>
<?php
exit();
}
?>
