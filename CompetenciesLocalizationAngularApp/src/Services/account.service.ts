import { Injectable } from '@angular/core';
import {environment} from '../environments/environment';
import {HttpClient} from '@angular/common/http';
import {FormGroup} from '@angular/forms';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AccountService {

  readonly AccountRootURL = environment.rootURL;
  public LoggedInAccount: any;
  public studentOrUniversityLoggedIn: any;   // student or university
  constructor(private http: HttpClient) { }

  changeLoggedInAccount(accountObject: any) {
    this.LoggedInAccount = accountObject;
  }
  changeLoggedIn(loggedInFor: any) {
    this.studentOrUniversityLoggedIn = loggedInFor;
  }

  SignInUserAccount(object: FormGroup): Observable<any> {
    return this.http.post<any>(this.AccountRootURL + 'user/signin.php', object);
  }

  AddStudentAccount(object: FormGroup): Observable<any> {
    return this.http.post<any>(this.AccountRootURL + 'user/create.php', object);
  }
  UpdateStudentAccount(object: FormGroup): Observable<any>{
    return this.http.put<any>(this.AccountRootURL + 'user/update.php', object);
  }
  deleteStudentAccount(id): Observable<any> {
    return this.http.post(this.AccountRootURL + 'user/delete.php', new Object({ClaimID: id}));
  }

  SignInUniversityAccount(object: FormGroup): Observable<any> {
    return this.http.post<any>(this.AccountRootURL + 'university/signin.php', object);
  }
  AddUniversityAccount(object: FormGroup): Observable<any> {
    return this.http.post<any>(this.AccountRootURL + 'university/create.php', object);
  }
  UpdateUniversityAccount(object: FormGroup): Observable<any>{
    return this.http.put<any>(this.AccountRootURL + 'university/update.php', object);
  }
  deleteUniversityAccount(id): Observable<any> {
    return this.http.post(this.AccountRootURL + 'university/delete.php', new Object({ClaimID: id}));
  }
  GetAllUniversities(): Observable<any> {
    return this.http.get<any>(this.AccountRootURL + 'university/read.php');
  }
}
