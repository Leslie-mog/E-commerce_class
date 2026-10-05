<?php
// classes/CustomerClass.php
require_once __DIR__ . '/../core/db_class.php';

class CustomerClass extends Database
{
    /**
     * Check if an email already exists in the customer table.
     */
    public function emailExists(string $email): bool
    {
        $stmt = $this->conn->prepare(
            "SELECT customer_id FROM customer WHERE customer_email = ? LIMIT 1"
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    /**
     * Insert a new customer. Password is hashed here.
     */
    public function addCustomer(
        string $name,
        string $email,
        string $pass,
        string $country,
        string $city,
        string $contact,
        ?string $image = null,
        int $role = 2
    ): bool {
        $hash = password_hash($pass, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare(
            "INSERT INTO customer
             (customer_name, customer_email, customer_pass,
              customer_country, customer_city, customer_contact,
              customer_image, user_role)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            'sssssssi',
            $name,
            $email,
            $hash,
            $country,
            $city,
            $contact,
            $image,
            $role
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /**
     * Get a customer by email (used by login later).
     */
    public function getCustomerByEmail(string $email)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM customer WHERE customer_email = ? LIMIT 1"
        );
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ?: false;
    }
    /**
     * Verify credentials. Returns the customer row on success, false on failure.
     */
    public function login(string $email, string $pass)
    {
        $row = $this->getCustomerByEmail($email);
        if (!$row) {
            return false;
        }
        if (!password_verify($pass, $row['customer_pass'])) {
            return false;
        }
        return $row;
    }
}
?>