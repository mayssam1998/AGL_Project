import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material';

@Component({
  selector: 'app-confirmation-dialog',
  templateUrl: './confirmation-dialog.component.html',
  styleUrls: ['./confirmation-dialog.component.css']
})
export class ConfirmationDialogComponent implements OnInit {

  constructor(public dialogRef: MatDialogRef<ConfirmationDialogComponent>,@Inject(MAT_DIALOG_DATA) public data: any) { }
  onConfirm(){
    this.dialogRef.close(true);
  }
  onDismiss(){
    this.dialogRef.close(false);
  }
  close(){
    this.dialogRef.close();
  }
  onStudentClick(){
    this.dialogRef.close("student");
  }
  onUniversityClick(){
    this.dialogRef.close("university");
  }
  ngOnInit() {
  }

}
