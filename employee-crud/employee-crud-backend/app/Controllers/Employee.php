<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Employee extends ResourceController
{
    protected $modelName = 'App\\Models\\EmployeeModel';
    protected $format    = 'json';

    // GET /api/employees
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // GET /employees/{id}
    public function show($id = null)
    {
        try {
            $employee = $this->model->find($id);
            if ($employee) {
                return $this->respond($employee);
            } else {
                return $this->failNotFound('Employee not found');
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // POST /employees
    public function create()
    {
        try {
            $data = $this->request->getJSON(true);
            if ($this->model->insert($data)) {
                $data['id'] = $this->model->getInsertID();
                return $this->respondCreated($data);
            } else {
                return $this->failValidationErrors($this->model->errors());
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // PUT /employees/{id}
    public function update($id = null)
    {
        try {
            $data = $this->request->getJSON(true);
            if ($this->model->update($id, $data)) {
                $updated = $this->model->find($id);
                return $this->respond($updated);
            } else {
                return $this->failValidationErrors($this->model->errors());
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }

    // DELETE /employees/{id}
    public function delete($id = null)
    {
        try {
            if ($this->model->delete($id)) {
                return $this->respondDeleted(['id' => $id]);
            } else {
                return $this->failNotFound('Employee not found');
            }
        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}
