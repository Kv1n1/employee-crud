import { Component, OnInit } from '@angular/core';
import { EmployeeService } from '../services/employee.service';
import { Employee } from '../model/employee';

@Component({
  selector: 'app-employee-list',
  templateUrl: './employee-list.component.html',
  styleUrls: ['./employee-list.component.css']
})
export class EmployeeListComponent implements OnInit {
  employees: Employee[] = [];
  errorMsg: string = '';
  selectedEmployee: Employee | null = null;

  constructor(private employeeService: EmployeeService) {}

  ngOnInit() {
    this.loadEmployees();
  }

  loadEmployees() {
    this.employeeService.getEmployees().subscribe({
      next: (data: Employee[]) => this.employees = data,
      error: (err: any) => this.errorMsg = 'Failed to load employees'
    });
  }

  editEmployee(emp: Employee) {
    this.selectedEmployee = { ...emp };
  }

  onEmployeeSaved() {
    this.selectedEmployee = null;
    this.loadEmployees();
  }

  deleteEmployee(id: number) {
    this.employeeService.deleteEmployee(id).subscribe({
      next: () => this.loadEmployees(),
      error: (err: any) => this.errorMsg = 'Delete failed'
    });
  }
}
