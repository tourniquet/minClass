<?php
  require_once('dbc.php');

  $data = $_POST;

  $email = mysqli_real_escape_string($dbc, trim(strtolower($data['email'])));
  $password = mysqli_real_escape_string($dbc, password_hash($data['password'], PASSWORD_DEFAULT));
  $password_confirmation = mysqli_real_escape_string($dbc, $data['passwordConfirmation']);

  if (!empty($email) && !empty($password) && !empty($password_confirmation)) {
    if (password_verify($password_confirmation, $password)) {
      // check if email is already taken
      $query = "SELECT * FROM cls_users WHERE email = '$email'";
      $data = mysqli_query($dbc, $query);

      header('Access-Control-Allow-Origin: *', false);
      header('Content-type: application/json', false);
      header('HTTP/1.1 200 OK');

      if (mysqli_num_rows($data) == 0) {
        // the email is unique, so insert the data into the database
        $query = "INSERT INTO cls_users (email, password) VALUES ('$email', '$password')";
        mysqli_query($dbc, $query) or die(mysqli_error($dbc));
        
        // confirm success with the user
        echo json_encode(['message' => 'Success!']);
      } elseif (mysqli_num_rows($data) > 0) {
        echo json_encode(['message' => 'Existing!']);
      }
    // password and confirmation password did not match
    } else {
      echo json_encode(['message' => 'Unmatch!']);
    }
  }

  mysqli_close($dbc);
?>
