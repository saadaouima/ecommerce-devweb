<?php
class User {
    private mysqli $db; // ✅ Declare $db explicitly to avoid dynamic property issues

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "eshop");

        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function createUser($data) {
        $first_name  = $this->db->real_escape_string($data['first_name']);
        $last_name   = $this->db->real_escape_string($data['last_name']);
        $address     = $this->db->real_escape_string($data['address']);
        $city        = $this->db->real_escape_string($data['city']);
        $governorate = $this->db->real_escape_string($data['governorate']);
        $postcode    = $this->db->real_escape_string($data['postcode']);
        $phone       = $this->db->real_escape_string($data['phone']);
        $email       = $this->db->real_escape_string($data['email']);
        $password    = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, address, city, governorate, postcode, phone, email, password)
                VALUES ('$first_name', '$last_name', '$address', '$city', '$governorate', '$postcode', '$phone', '$email', '$password')";

        return $this->db->query($sql);
    }
}
?>
