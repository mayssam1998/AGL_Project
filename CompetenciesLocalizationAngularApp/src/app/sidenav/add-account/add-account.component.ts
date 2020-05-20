import {AfterViewInit, Component, OnDestroy, OnInit} from '@angular/core';
import {Observable, Subscription} from 'rxjs';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {MatChipInputEvent, MatDialog} from '@angular/material';
import {ActivatedRoute} from '@angular/router';
import {AccountService} from '../../../Services/account.service';
import {ConfirmationDialogComponent} from '../confirmation-dialog/confirmation-dialog.component';
import {COMMA, ENTER} from '@angular/cdk/keycodes';
import {map, startWith} from 'rxjs/operators';
import {SkillsService} from '../../../Services/skills.service';
import {DatePipe} from '@angular/common';
import {LocationsService} from '../../../Services/locations.service';
interface Proficiency {
  value: string;
  viewValue: string;
}
@Component({
  selector: 'app-add-account',
  templateUrl: './add-account.component.html',
  styleUrls: ['./add-account.component.css']
})
export class AddAccountComponent implements OnInit, OnDestroy, AfterViewInit{

  SkillControl = new FormControl();

  // All autocomplete values
  allSkills = [];
  allUniversities = [];
  allCities = [];

  // All filtered option for autocomplete inputs
  filteredOptions: Observable<any[]>;
  filteredUniversitiesOptions: Observable<any[]>;
  filteredCitiesOptions: Observable<any[]>;
  filteredCitiesOptionsForUni: Observable<any[]>;

  subscriptionList: Array<Subscription> = [];

  StudentAccountForm = new FormGroup({
    id: new FormControl(0),
    first_name: new FormControl('', [Validators.required]),
    last_name: new FormControl('', [Validators.required]),
    date_of_birth: new FormControl('', [Validators.required]),
    city_id: new FormControl(0),
    city_name: new FormControl('', [Validators.required]),
    university_id: new FormControl(0),
    university_name: new FormControl('', [Validators.required]),
    skills: new FormControl([]),
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)])
  });
  UniversityAccountForm = new FormGroup({
    id: new FormControl(0),
    name: new FormControl('', [Validators.required]),
    city_id: new FormControl(0),
    city_name: new FormControl('', [Validators.required]),
    telephone_number: new FormControl(0, [Validators.required]),
    website: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)])
  });

  PasswordPattern = "^[a-z0-9_-]{8,15}$";
  AccountFor = "student";


  disableBtnStudent = false;
  disableBtnUniversity = false;
 // selectedValue: string;
  selectedValue = new FormControl();
  proficiencies: Proficiency[] = [
    {value: 'Beginner', viewValue: 'Beginner'},
    {value: 'Intermediate', viewValue: 'Intermediate'},
    {value: 'Advanced', viewValue: 'Advanced'}
  ];

  constructor(public dialog: MatDialog, private route: ActivatedRoute, public accountService: AccountService,
              public skillService: SkillsService, public datepipe: DatePipe, public locationService: LocationsService) {
  }

  found = false;

  // Add new skill function
  AddNewSkill(){
    this.allSkills.forEach(val => {
      if(val.description.match(this.SkillControl.value)){
        this.StudentAccountForm.controls['skills'].value.push({
          id: val.id,
          description: this.SkillControl.value,
          proficiency: this.selectedValue.value
        });
        this.found = true;
      }
    });
    if(!this.found){
      const dialogRef6 = this.dialog.open(ConfirmationDialogComponent, {
        width: '450px',
        data: { message: "Skill name is not valid. Please enter a valid skill.", type: 'message'}
      });
    }
  }

  // Set Id By name functions
  setUniversityIdByName(){
    this.found = false;
    this.allUniversities.forEach(val => {
      if(val.name.match(this.StudentAccountForm.controls['university_name'].value)){
        this.StudentAccountForm.controls['university_id'].setValue(val.id);
        this.found = true;
      }
    });
    if(!this.found) {
      const dialogRef1 = this.dialog.open(ConfirmationDialogComponent, {
        width: '450px',
        data: {message: "University name is not valid. Please enter a valid university name.", type: 'message'}
      });
    }
  }


  setCityIdByName(){
    this.found = false;
    this.allCities.forEach(val => {
      if(val.name.match(this.StudentAccountForm.controls['city_name'].value)){
        this.StudentAccountForm.controls['city_id'].setValue(val.id);
        this.found = true;
      }
    });
    if(!this.found) {
      const dialogRef2 = this.dialog.open(ConfirmationDialogComponent, {
        width: '450px',
        data: {message: "City name is not valid. Please enter a valid city name.", type: 'message'}
      });
    }
  }

  setCityIdByNameForUni(){
    this.found = false;
    this.allCities.forEach(val => {
      if(val.name.match(this.UniversityAccountForm.controls['city_name'].value)){
        this.UniversityAccountForm.controls['city_id'].setValue(val.id);
        this.found = true;
      }
    });
    if(!this.found) {
      const dialogRef3 = this.dialog.open(ConfirmationDialogComponent, {
        width: '450px',
        data: {message: "City name is not valid. Please enter a valid city name.", type: 'message'}
      });
    }
  }

  changeDateFormat(){
    const date = new Date(this.StudentAccountForm.controls['date_of_birth'].value); // had to remove the colon (:) after the T in order to make it work
    let latest_date =this.datepipe.transform(date, 'yyyy-MM-dd');
    return latest_date;
  }
  // Add user On Submit
  SubmitAccount(){
    const dialogRef4 = this.dialog.open(ConfirmationDialogComponent, {
      width: '450px',
      data: { message: "Are you sure you want to submit this Account?", type: 'confirm'}
    });
    dialogRef4.afterClosed().subscribe(result => {
      if(result) {
        if(this.AccountFor.match("student") ) {
          this.StudentAccountForm.controls['date_of_birth'].setValue(this.changeDateFormat());
          this.setUniversityIdByName();
          this.setCityIdByName();
          console.log(this.StudentAccountForm.getRawValue());
            this.subscriptionList.push(this.accountService.AddStudentAccount(this.StudentAccountForm.getRawValue()).subscribe((response) => {
              console.log(response);
              this.resetStudentForm();
            }));
        } else if (this.AccountFor.match("university")) {
          this.setCityIdByNameForUni();
          console.log(this.UniversityAccountForm.controls['city_id'].value);
            this.subscriptionList.push(this.accountService.AddUniversityAccount(this.UniversityAccountForm.getRawValue()).subscribe((response) => {
              console.log(response);
              this.resetUniversityForm();
            }));
        }
      }
    });
  }

  // Reset Functions
  resetStudentForm(){
    this.StudentAccountForm.controls['first_name'].setValue('');
    this.StudentAccountForm.controls['last_name'].setValue('');
    this.StudentAccountForm.controls['date_of_birth'].setValue('');
    this.StudentAccountForm.controls['city_name'].setValue('');
    this.StudentAccountForm.controls['university_name'].setValue('');
    this.StudentAccountForm.controls['skills'].setValue([]);
    this.StudentAccountForm.controls['email'].setValue('');
    this.StudentAccountForm.controls['password'].setValue('');
    this.SkillControl.setValue('');
    this.selectedValue.setValue('');
  }

  resetUniversityForm(){
    this.UniversityAccountForm.controls['name'].setValue('');
    this.UniversityAccountForm.controls['city_name'].setValue('');
    this.UniversityAccountForm.controls['telephone_number'].setValue('');
    this.UniversityAccountForm.controls['website'].setValue('');
    this.UniversityAccountForm.controls['email'].setValue('');
    this.UniversityAccountForm.controls['password'].setValue('');
  }

  //Autocomplete Filters
  _filter(value: string): string[] {
    const filterValue = value.toString().toLowerCase();
    return this.allSkills.filter(option => option.description.toLowerCase().includes(filterValue));
  }

  _filterUniversities(value: string): string[] {
    const filterValue = value.toString().toLowerCase();
    return this.allUniversities.filter(option => option.name.toLowerCase().includes(filterValue));
  }

  _filterCities(value: string): string[] {
    const filterValue = value.toString().toLowerCase();
    return this.allCities.filter(option => option.name.toLowerCase().includes(filterValue));
  }

  ngOnInit() {

  }

  ngAfterViewInit(){
    setTimeout(() => {

      // Account for Uni or Student
        const dialogRef5 = this.dialog.open(ConfirmationDialogComponent, {
          width: '450px',
          data: { message: "Do you want to create a student or a university account?", type: 'AccountFor'}
        });
        dialogRef5.afterClosed().subscribe(result => {
          if(result) {
            this.AccountFor = result;
            console.log(this.AccountFor );
          }
        });


        /////API to add
        // fill all possible skills
      this.subscriptionList.push(
        this.skillService.GetAllSkills().subscribe((response) => {
          if(response){
            this.allSkills = response.data;
          }
        }));

      // fill all possible universities
      this.subscriptionList.push(
        this.accountService.GetAllUniversities().subscribe((response) => {
          if(response){
            this.allUniversities = response.data;
          }
        }));

      // fill all possible cities
      this.subscriptionList.push(
        this.locationService.GetAllCities().subscribe((response) => {
          if(response){
            this.allCities = response.data;
          }
        }));

        // Filter options for Autocomplete
    this.filteredOptions = this.SkillControl.valueChanges
      .pipe(
        startWith(''),
        map(value => this._filter(value))
      );

    this.filteredUniversitiesOptions = this.StudentAccountForm.controls['university_name'].valueChanges
      .pipe(
        startWith(''),
        map(value => this._filterUniversities(value))
      );
    this.filteredCitiesOptions = this.StudentAccountForm.controls['city_name'].valueChanges
      .pipe(
        startWith(''),
        map(value => this._filterCities(value))
      );

      this.filteredCitiesOptionsForUni = this.UniversityAccountForm.controls['city_name'].valueChanges
        .pipe(
          startWith(''),
          map(value => this._filterCities(value))
        );

      // Disable or enable the form button
      this.StudentAccountForm.valueChanges
        .subscribe((changedObj: any) => {
          this.disableBtnStudent = this.StudentAccountForm.valid;
        });

      this.UniversityAccountForm.valueChanges
        .subscribe((changedObj: any) => {
          this.disableBtnUniversity = this.UniversityAccountForm.valid;
        });


    });
  }


  ngOnDestroy(): void {
    this.subscriptionList.forEach(sub => sub.unsubscribe());
  }
}
