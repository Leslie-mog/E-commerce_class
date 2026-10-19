<?php
// controllers/CustomerController.php
require_once __DIR__ . '/../classes/CustomerClass.php';

class CustomerController
{
    private CustomerClass $model;

    public function __construct()
    {
        $this->model = new CustomerClass();
    }

    /**
     * Register a new customer.
     * Returns ['success' => true] or ['success' => false, 'error' => '...'].
     */
    public function register(array $data): array
    {
        if ($this->model->emailExists($data['email'])) {
            return ['success' => false, 'error' => 'That email is already registered.'];
        }

        $ok = $this->model->addCustomer(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['country'],
            $data['city'],
            $data['contact'],
            $data['image'] ?? null
        );

        if (!$ok) {
            return ['success' => false, 'error' => 'Could not create your account. Please try again.'];
        }

        return ['success' => true];
    }
    // In controllers/CustomerController.php, inside the class:

    /**
     * Attempt login.
     * Returns ['success' => true, 'customer' => [...]] or
     *         ['success' => false, 'error' => '...'].
     */
    public function login(string $email, string $pass): array
    {
        $row = $this->model->login($email, $pass);
        if (!$row) {
            return ['success' => false, 'error' => 'Invalid email or password.'];
        }
        return ['success' => true, 'customer' => $row];
    }
    public function getByEmailForSession(string $email): array
    {
        $row = $this->model->getCustomerByEmail($email);
        if (!$row) {
            return [];
        }
        return $row;
    }
}
?>