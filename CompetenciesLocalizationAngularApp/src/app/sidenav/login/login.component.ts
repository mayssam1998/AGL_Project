import {AfterViewInit, Component, OnDestroy, OnInit} from '@angular/core';
import {Subscription} from 'rxjs';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {MatDialog} from '@angular/material';
import {ActivatedRoute} from '@angular/router';
import {AccountService} from '../../../Services/account.service';
import {ConfirmationDialogComponent} from '../confirmation-dialog/confirmation-dialog.component';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit, OnDestroy, AfterViewInit {

  constructor(public dialog: MatDialog, private route: ActivatedRoute, public accountService: AccountService) { }

  subscriptionList: Array<Subscription> = [];

  LoginAccountForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required])
  });

  disableBtn = false;
  LoginToAccount(){
    if(this.accountService.studentOrUniversityLoggedIn.match('student')) {
      this.subscriptionList.push(
        this.accountService.SignInUserAccount(this.LoginAccountForm.getRawValue()).subscribe((response) => {
          if (!response.message) {
            console.log(response);
            this.accountService.changeLoggedInAccount(response);
          } else if (response.message){
            const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
              width: '450px',
              data: {message: "Email or Password not correct.Please try again.", type: 'message'}
            });
          }
        }));
    } else if(this.accountService.studentOrUniversityLoggedIn.match('university')){
      this.subscriptionList.push(
        this.accountService.SignInUniversityAccount(this.LoginAccountForm.getRawValue()).subscribe((response) => {
          if (response) {
            console.log(response);
            this.accountService.changeLoggedInAccount(response);
          } else {
            const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
              width: '450px',
              data: {message: "Email or Password not correct.Please try again.", type: 'message'}
            });
          }
        }));
    }
    this.resetLoginForm();
  }

  resetLoginForm(){
    this.LoginAccountForm.controls['email'].setValue('');
    this.LoginAccountForm.controls['password'].setValue('');
  }

  ngAfterViewInit(){
    setTimeout(() => {

      const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
        width: '450px',
        data: { message: "Do you want to sign in to a student or a university account?", type: 'AccountFor'}
      });
      dialogRef.afterClosed().subscribe(result => {
        if(result) {
          this.accountService.changeLoggedIn(result);
        }
      });

      // Disable or enable the form button
      this.LoginAccountForm.valueChanges
        .subscribe((changedObj: any) => {
          this.disableBtn = this.LoginAccountForm.valid;
        });
    });
  }
  ngOnInit() {
  }

  ngOnDestroy(): void {
    this.subscriptionList.forEach(sub => sub.unsubscribe());
  }
}
