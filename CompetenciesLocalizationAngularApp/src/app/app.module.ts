import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { AppComponent } from './app.component';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import { SidenavComponent } from './sidenav/sidenav.component';
import {appRoutes} from './routerConfig';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {
  MatButtonModule,
  MatChipsModule,
  MatDialogModule,
  MatExpansionModule,
  MatFormFieldModule,
  MatIconModule,
  MatInputModule,
  MatTableModule,
  MatListModule,
  MatSidenavModule,
  MatToolbarModule,
  MatDatepickerModule,
  MatNativeDateModule,
  MatAutocompleteModule,
  MatRadioModule,
  MatCheckboxModule,
  MatSortModule,
  MatMenuModule,
  MatSelectModule
} from '@angular/material';
import { ConfirmationDialogComponent } from './sidenav/confirmation-dialog/confirmation-dialog.component';
import {HttpClientModule} from '@angular/common/http';
import { SearchCompetencyComponent } from './sidenav/search-competency/search-competency.component';
import { LoginComponent } from './sidenav/login/login.component';
import { AddAccountComponent } from './sidenav/add-account/add-account.component';
import { UpdateAccountComponent } from './sidenav/update-account/update-account.component';
import {AgmCoreModule} from '@agm/core';
import {DatePipe} from '@angular/common';
import { LocationDetailsDialogComponent } from './sidenav/search-competency/location-details-dialog/location-details-dialog.component';
@NgModule({
  declarations: [
    AppComponent,
    SidenavComponent,
    ConfirmationDialogComponent,
    SearchCompetencyComponent,
    LoginComponent,
    AddAccountComponent,
    UpdateAccountComponent,
    LocationDetailsDialogComponent
  ],
  imports: [
    AgmCoreModule.forRoot({
      apiKey: 'AIzaSyAhKxBYNJc_NNWVjSYlvHvW7MvwbRXk-dM'
    }),
    BrowserModule,
    MatSidenavModule,
    MatListModule,
    MatIconModule,
    MatToolbarModule,
    BrowserAnimationsModule,
    RouterModule.forRoot(appRoutes),
    MatFormFieldModule,
    MatInputModule,
    FormsModule,
    ReactiveFormsModule,
    MatButtonModule,
    MatChipsModule,
    MatDialogModule,
    MatExpansionModule,
    MatTableModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatAutocompleteModule,
    MatRadioModule,
    MatCheckboxModule,
    MatSortModule,
    HttpClientModule,
    MatMenuModule,
    MatSelectModule
  ],
  providers: [DatePipe],
  bootstrap: [AppComponent],
  entryComponents: [ConfirmationDialogComponent, LocationDetailsDialogComponent]
})
export class AppModule { }
