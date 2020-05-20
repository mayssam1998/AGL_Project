import { Injectable } from '@angular/core';
import {environment} from '../environments/environment';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LocationsService {

  readonly LocationsRootURL = environment.rootURL + 'city/';

  constructor(private http: HttpClient) { }

  GetAllCities(): Observable<any> {
    return this.http.get<any>(this.LocationsRootURL + 'read.php');
  }
  getCitiesBySkill(object: any): Observable<any> {
    return this.http.post<any>(this.LocationsRootURL + 'readtopk.php', object);
  }
}
