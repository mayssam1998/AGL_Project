import { Injectable } from '@angular/core';
import {environment} from '../environments/environment';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SkillsService {

  readonly SkillsRootURL = environment.rootURL + 'skill/';
  constructor(private http: HttpClient) { }


  GetAllSkills(): Observable<any> {
    return this.http.get<any>(this.SkillsRootURL + 'read.php');
  }
}
