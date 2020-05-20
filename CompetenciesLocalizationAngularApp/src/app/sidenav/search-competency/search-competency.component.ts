import {AfterViewInit, Component, forwardRef, OnDestroy, OnInit} from '@angular/core';
import {Observable, Subscription} from 'rxjs';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {MatDialog} from '@angular/material';
import {LocationsService} from '../../../Services/locations.service';
import {map, startWith} from 'rxjs/operators';
import {ConfirmationDialogComponent} from '../confirmation-dialog/confirmation-dialog.component';
import {SkillsService} from '../../../Services/skills.service';
import {AgmMarker, FitBoundsAccessor} from '@agm/core';
import {LocationDetailsDialogComponent} from './location-details-dialog/location-details-dialog.component';

@Component({
  selector: 'app-search-competency',
  providers: [
    { provide: FitBoundsAccessor, useExisting: forwardRef(() => AgmMarker) },
  ],
  templateUrl: './search-competency.component.html',
  styleUrls: ['./search-competency.component.css']
})
export class SearchCompetencyComponent implements OnInit, OnDestroy, AfterViewInit{

  subscriptionList: Array<Subscription> = [];
  latitude = 33.868481;
  longitude =  34.7262021;
  MapLocations = [];

  allSkills = [];

  filteredOptions: Observable<any[]>;

  disableBtnSearch = false;

  SearchForm = new FormGroup({
    id: new FormControl(0),
    competency: new FormControl('', [Validators.required]),
    k: new FormControl(0)
  });
  constructor(public dialog: MatDialog, public locationService: LocationsService, public skillService: SkillsService) { }

 locationChosen = false;

  found = false;

  setSkillId(){
    console.log(this.allSkills);
    console.log(this.SearchForm.controls['competency'].value);
    this.found = false;
      this.allSkills.forEach(val => {
        if (val.description.match(this.SearchForm.controls['competency'].value)) {
          this.SearchForm.controls['id'].setValue(val.id);
          this.found = true;
        }
      });
    if(!this.found) {
      const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
        width: '450px',
        data: {message: "Skill name is not valid. Please enter a valid skill.", type: 'message'}
      });
    }
  }

  FillMap(){
          this.setSkillId();
          this.SearchForm.controls['k'].setValue(6);
          console.log(this.SearchForm.getRawValue());
          this.subscriptionList.push(
            this.locationService.getCitiesBySkill(this.SearchForm.getRawValue()).subscribe((response) => {
              if(response) {
                this.resetSearchForm();
                console.log(response);
                this.MapLocations = response.data;
              }
            }));
  }

  resetSearchForm(){
    this.SearchForm.controls['competency'].setValue('');
    this.SearchForm.controls['k'].setValue('');
  }

  _filter(value: string): string[] {
    const filterValue = value.toString().toLowerCase();
    return this.allSkills.filter(option => option.description.toLowerCase().includes(filterValue));
  }

  showDialogForMoreInfo(location: any){
    console.log(location);
    const dialogRef = this.dialog.open(LocationDetailsDialogComponent, {
      width: '450px',
      data: location
    });
  }

  ngOnInit() {
  }

  ngAfterViewInit() {
    setTimeout(() => {
      // fill all possible skills
       this.subscriptionList.push(
         this.skillService.GetAllSkills().subscribe((response) => {
           if(response){
             this.allSkills = response.data;
           }
         }));

      this.filteredOptions = this.SearchForm.controls['competency'].valueChanges
        .pipe(
          startWith(''),
          map(value => this._filter(value))
        );

      // Disable or enable the form button
      this.SearchForm.valueChanges
        .subscribe((changedObj: any) => {
          this.disableBtnSearch = this.SearchForm.valid;
        });
    });
  }

  ngOnDestroy(): void {
    this.subscriptionList.forEach(sub => sub.unsubscribe());
  }

}
