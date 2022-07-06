<?php
    require_once "Model.php";
    session_start();
    if (isset($_SESSION['activeUser'])){
        $user = unserialize($_SESSION['activeUser']);
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        if($name !== $user->getName()) $user->setName($name);
        if($surname !== $user->getSurname()) $user->setSurname($surname);
        if($email !== $user->getEmail()) $user->setEmail($email);
        if($age !== $user->getAge()) $user->setAge($age);
        if($gender !== $user->getGender()) $user->setGender($gender);
        $_SESSION['activeUser'] = serialize($user);
        session_write_close();
        header('Location: ./UserProfile.php');
        die();
    }
?>