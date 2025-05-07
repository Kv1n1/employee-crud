<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Employees extends ResourceController
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        // Handle preflight (OPTIONS) requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }
    use ResponseTrait;
    public function index() {
        $model = new \App\Models\EmployeeModel();
        $employees = $model->findAll();
        return $this->respond($employees);
    }

    public function show($id = null) {
        $model = new \App\Models\EmployeeModel();
        $employee = $model->find($id);
        if ($employee) {
            return $this->respond($employee);
        }
        return $this->failNotFound('Employee not found');
    }

    public function create() {
        $model = new \App\Models\EmployeeModel();
        $data = $this->request->getJSON(true);
        $id = $model->insert($data);
        if ($id) {
            $data['empid'] = $id;
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($model->errors());
    }

    public function update($id = null) {
        $model = new \App\Models\EmployeeModel();
        $data = $this->request->getJSON(true);
        if ($model->update($id, $data)) {
            $employee = $model->find($id);
            return $this->respond($employee);
        }
        return $this->failNotFound('Employee not found');
    }

    public function delete($id = null) {
        $model = new \App\Models\EmployeeModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failNotFound('Employee not found');
    }
}
