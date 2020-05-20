import {Routes} from '@angular/router';
import {SearchCompetencyComponent} from './sidenav/search-competency/search-competency.component';
import {LoginComponent} from './sidenav/login/login.component';
import {AddAccountComponent} from './sidenav/add-account/add-account.component';
import {UpdateAccountComponent} from './sidenav/update-account/update-account.component';

export const appRoutes: Routes = [
  { path: 'Register',
    component: AddAccountComponent
  },
  { path: 'UpdateAccount',
    component: UpdateAccountComponent
  },
  {
    path: 'Login',
    component: LoginComponent
  },
  { path: 'Search',
    component: SearchCompetencyComponent
  },
  {
    path: '',
    component: SearchCompetencyComponent
  }
];
