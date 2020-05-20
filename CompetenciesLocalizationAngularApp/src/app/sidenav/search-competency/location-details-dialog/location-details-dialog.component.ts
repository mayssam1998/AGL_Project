import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material';

@Component({
  selector: 'app-location-details-dialog',
  templateUrl: './location-details-dialog.component.html',
  styleUrls: ['./location-details-dialog.component.css']
})
export class LocationDetailsDialogComponent implements OnInit {

  constructor(public dialogRef: MatDialogRef<LocationDetailsDialogComponent>,@Inject(MAT_DIALOG_DATA) public data: any) { }


  close(){
    this.dialogRef.close();
  }

  ngOnInit() {
  }

}
