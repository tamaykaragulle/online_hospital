<?php
class Doctor
{
    protected string $doctor_name = "";
    protected string $doctor_password = "";
    protected string $doctor_mail = "";
}

function __construct(string $doctor_name, string $doctor_password, string $doctor_mail)
{
    $this->doctor_name = $doctor_name;
    if ($doctor_password) $this->doctor_password = $doctor_password;
    if ($doctor_email) $this->doctor_email = $doctor_email;
}

function insertToDb():
    bool
    {
        if (!$this->doctor_mail) return false;
        if ($this->user_exits()) return false;
        $mysqli = new mysqli("localhost", "root", "", "online_hospital_db");
        $statement = $mysqli->prepare("INSERT INTO users(doctor_name,doctor_password,doctor_mail) VALUES (?,?,?)");
        $statement->bind_param('sss', $this->doctor_name, $this->doctor_password, $this->doctor_mail);
        $statement->execute();
        return true;
    }
?>
