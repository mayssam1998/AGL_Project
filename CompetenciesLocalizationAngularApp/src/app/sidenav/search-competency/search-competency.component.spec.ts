import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SearchCompetencyComponent } from './search-competency.component';

describe('SearchCompetencyComponent', () => {
  let component: SearchCompetencyComponent;
  let fixture: ComponentFixture<SearchCompetencyComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SearchCompetencyComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SearchCompetencyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
