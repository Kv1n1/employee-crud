import { Component, Input, Output, EventEmitter, OnInit, OnChanges } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Employee } from '../model/employee';
import { EmployeeService } from '../services/employee.service';

@Component({
  selector: 'app-employee-form',
  templateUrl: './employee-form.component.html',
  styleUrls: ['./employee-form.component.css']
})
export class EmployeeFormComponent implements OnInit, OnChanges {
  @Input() employee: Employee | null = null;
  @Output() saved = new EventEmitter<void>();
  employeeForm: FormGroup;
  successMsg = '';
  errorMsg = '';

  constructor(private fb: FormBuilder, private employeeService: EmployeeService) {
    this.employeeForm = this.fb.group({
      name: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      contact_no: ['']
    });
  }

  ngOnInit() {
    if (this.employee) {
      this.employeeForm.patchValue({
        name: this.employee.name,
        email: this.employee.email,
        contact_no: this.employee.contact_no
      });
    } else {
      this.employeeForm.reset();
    }
  }

  ngOnChanges() {
    if (this.employee) {
      this.employeeForm.patchValue({
        name: this.employee.name,
        email: this.employee.email,
        contact_no: this.employee.contact_no
      });
    } else {
      this.employeeForm.reset();
    }
  }

  onSubmit() {
    if (this.employeeForm.invalid) return;
    const data = this.employeeForm.value;
    if (this.employee && this.employee.id) {
      this.employeeService.updateEmployee(this.employee.id, data).subscribe({
        next: () => {
          this.successMsg = 'Employee updated!';
          this.saved.emit();
        },
        error: (err: any) => this.errorMsg = 'Update failed'
      });
    } else {
      this.employeeService.addEmployee(data).subscribe({
        next: () => {
          this.successMsg = 'Employee added!';
          this.saved.emit();
        },
        error: (err: any) => this.errorMsg = 'Add failed'
      });
    }
  }
}
