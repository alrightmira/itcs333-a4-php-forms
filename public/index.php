<?php
declare(strict_types=1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/validate.php';

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function post_str(string $key): string
{
  if(isset($_POST[$key]) && is_string($_POST[$key])) {return $_POST[$Key] ;} //end if

  return " ";
}

$errors = [];
$values = ['name' => '', 'email' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['name']    = trim(post_str('name')); $values['email']   = trim(post_str('email')); $values['message'] = trim(post_str('message'));
    
  
   
    if (!validate_required($values['name'])) {
        $errors['name'] = 'Name is required.';
    } 
    
    elseif (!validate_length($values['name'], 2, 60)) {
        $errors['name'] = 'Name is invalid: it must be 2 to 60 characters.';
    }

    if (!validate_required($values['email'])) {
        $errors['email'] = 'Email is required.';
    } 
    
    elseif (!validate_email($values['email'])) {
        $errors['email'] = 'Email is invalid.';
    }

   
    if (!validate_required($values['message'])) {
        $errors['message'] = 'Message is required.';
    } 
    elseif (!validate_length($values['message'], 10, 1000)) {
        $errors['message'] = 'Message is too short or too long: use 10 to 1000 characters.';
    }

    
    if (!$errors) {
        header('Location: success.php', true, 303);
        exit;
    }
   
}//end if
?> 


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
  <style>.error { color: #b00020; display: block; }</style>
</head>
<body>
  <h1>Contact Us</h1>
  <form method="post" action="index.php">
    <p>
      <label>Name
        <input type="text" name="name" value="<?php echo e($values['name']) ?>">
      </label>
      <?php if (isset($errors['name'])) {
         ?>
        <span class="error"> <?php echo e($errors['name']) ?> </span>
      <?php 
      } //end if
       ?>
    </p>


    <p>
      <label>Email
        <input type="email" name="email" value="<?php echo e($values['email']) ?>">
      </label>

      <?php if (isset($errors['email'])) { ?>
        <span class="error"><? php echo e($errors['email']); ?></span>
      <?php }//end if ?>
    </p>

    <p>
      <label>Message
        <textarea name="message"><?php echo e($values['message']) ?></textarea>
      </label>
      <?php if (isset($errors['message'])) { ?>
        <span class="error"><?php echo e($errors['message']) ?></span>
      <?php }//end if ?>
    </p>

    <button type="submit">Send</button>
  </form>
</body>
</html>
