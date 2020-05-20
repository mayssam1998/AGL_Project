import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LocationDetailsDialogComponent } from './location-details-dialog.component';

describe('LocationDetailsDialogComponent', () => {
  let component: LocationDetailsDialogComponent;
  let fixture: ComponentFixture<LocationDetailsDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LocationDetailsDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LocationDetailsDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
