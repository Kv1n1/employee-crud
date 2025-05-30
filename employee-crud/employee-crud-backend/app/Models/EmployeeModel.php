<?php
namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'contact_no', 'city', 'state', 'pin_code', 'address'
    ];
    protected $returnType = 'array';
}
