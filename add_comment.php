<?php

$connect = new PDO('mysql:host=localhost;dbname=praktika', 'root', '');

$error = '';
$comment_name = '';
$comment_content = '';
$comment_email = '';

if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Vardo laukelis turi būti užpildytas</p>';
}
else if (!preg_match("/^[a-žA-Ž ]*$/",$_POST["comment_name"])) {
  $error .= '<p class="text-danger">Tik raidės leidžiamos vardo skiltyje</p>';
}
else
{
 $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_email"]))
{
 $error .= '<p class="text-danger">Emailo laukelis turi būti užpildytas</p>';
}
else if (!filter_var($_POST["comment_email"], FILTER_VALIDATE_EMAIL)) {
  $error .= '<p class="text-danger">Blogai parašytas Email, turi būti @ ir .</p>';
}
else
{
$comment_email = $_POST["comment_email"];
}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Komentavimo laukelis turi būti užpildytas</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if($error == '')
{
  $query = "INSERT INTO praktik (parent_comment_id, comment, comment_nam, comment_emails)
  VALUES (:parent_comment_id, :comment, :comment_nam, :comment_emails)";
  $statement = $connect->prepare($query);
  $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'           => $comment_content,
   ':comment_nam'       => $comment_name,
   ':comment_emails'    => $comment_email)
  );
  $error = '<label class="text-success">Comment Added</label>';
}

$data = array('error'   => $error);

echo json_encode($data);

?>
