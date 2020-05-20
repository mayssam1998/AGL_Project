import {Component, HostListener, OnInit, ViewChild} from '@angular/core';
import {MatSidenav} from '@angular/material';
import {AccountService} from '../../Services/account.service';

@Component({
  selector: 'app-sidenav',
  templateUrl: './sidenav.component.html',
  styleUrls: ['./sidenav.component.css']
})
export class SidenavComponent implements OnInit {

  constructor(public accountService: AccountService) { }

  opened = false;
  ngOnInit() {}
  isBiggerScreen() {
    const width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    return width < 768;
  }

  SignOut(){
    this.accountService.changeLoggedInAccount(null);
    this.accountService.changeLoggedIn(null);
  }

}
