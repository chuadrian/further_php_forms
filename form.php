<?php

$rules = array(
    'name' => array(
        'required' => true,
        'min_length' => 4,
        'max_length' => 15
    ),
    'email' => array(
        'required' => true,
        'email' => true
    ),
    'password' => array(
        'required' => true,
        'min_length' => 8,
        'max_length' => 20
    ),
    'confirm_password' => array(
        'required' => true,
        'matches' => 'password'
    )
);

$errors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach($rules as $field => $rule){
        if(!validate($field, $rule)){
            $errors[$field] = get_error($field, $rule);
        }
    }
    if(empty($errors)){
        echo "Form Submitted Successfully";
    }
}

function validate($field, $rule){
    $value = isset($_POST[$field]) ? $_POST[$field] : '';

    if($rule['required'] && empty($value)){
        return false;
    }
    if(isset($rule['min_length']) && strlen($value) < $rule['min_length']){
        return false;
    }
    if(isset($rule['max_length']) && strlen($value) > $rule['max_length']){
        return false;
    }
    if(isset($rule['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)){
        return false;
    }
    if(isset($rule['matches']) && $value != $_POST[$rule['matches']]){
        return false;
    }
    return true;
}

function get_error($field, $rule){
    switch($field){
        case 'name':
            if(isset($rule['required'])){
                return "Name is required";
            }elseif(isset($rule['min_length'])){
                return "Name must be at least " . $rule['min_length'] . " characters";
            }elseif(isset($rule['max_length'])){
                return "Name must be no more than " . $rule['max_length'] . " characters";
            }
            break;
        case 'email':
            if(isset($rule['required'])){
                return "Email is required";
            }elseif(isset($rule['email'])){
                return "Invalid email address";
            }
            break;
        case 'password':
            if(isset($rule['required'])){
                return "Password is required";
            }elseif(isset($rule['min_length'])){
                return "Password must be at least " . $rule['min_length'] . " characters";
            }elseif(isset($rule['max_length'])){
                return "Password must be no more than " . $rule['max_length'] . " characters";
            }
            break;
        case 'confirm_password':
            if(isset($rule['required'])){
                return "Confirm Password is required";
            }elseif(isset($rule['matches'])){
                return "Passwords do not match";
            }
            break;
    }
    return "Unknown error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Practice On Php Forms</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="form.php" method="post">
    <label for="name">Name: </label>
    <input type="text" id="name" name="name"><br><br>
    <?php if(isset($errors['name'])){ echo htmlspecialchars($errors['name']); }?>

    <label for="email">Email: </label>
    <input type="email" id="email" name="email"><br><br>
    <?php if(isset($errors['email'])){ echo htmlspecialchars($errors['email']); }?>

    <div class="password-group">
        <input type="checkbox" id="show_password" class="show-password-checkbox">
        <label for="show_password">Show Password</label>
    </div><br>

    <label for="password">Password: </label>
    <input type="password" id="password" name="password"><br><br>
    <?php if(isset($errors['password'])){ echo htmlspecialchars($errors['password']); }?>

    <label for="confirm_password">Confirm Password: </label>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>
    <?php if(isset($errors['confirm_password'])){ echo htmlspecialchars($errors['confirm_password']); }?>
    
    <input type="submit" value="Submit">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
    const showPasswordCheckbox = document.getElementById('show_password');

    showPasswordCheckbox.addEventListener('change', function() {
        if (this.checked) {
            passwordField.type = 'text';
            confirmPasswordField.type = 'text';
        } else {
            passwordField.type = 'password';
            confirmPasswordField.type = 'password';
        }
    });
});
</script>

</body>
</html>
