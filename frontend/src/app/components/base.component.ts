import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/index';
import { User } from '../models/user';

declare var soundManager: any;
declare var sm2BarPlayers: any;

@Component({
  selector: 'app-root',
  templateUrl: '../views/base.component.html',
  providers: [AuthService]
  //styleUrls: ['../../assets/soundmanager2/styles/bar-ui.css']
})
export class BaseComponent implements OnInit {
  currentUser: User;
  tokenId: Number;
  constructor(private authService: AuthService) { };
  ngOnInit() {

    if(localStorage.getItem('auth-tokens')) {
      this.getUserByToken();
    }

    //We load css after js is loaded
    var stylesheet = document.createElement('link');
    stylesheet.href = '../../assets/soundmanager2/styles/bar-ui.css';
    stylesheet.rel = 'stylesheet';
    stylesheet.type = 'text/css';
    document.getElementsByTagName('head')[0].appendChild(stylesheet);
  }
  title = 'RZik - Go ahead ! Everysing is in the bass';

  getUserByToken() {
    var that = this;
    this.authService.getAuthUserByToken()
                    .then((retour) => {
                      that.currentUser = retour[0]['user'] as User;
                    })
  }
  disconnect() {
    var that = this;
    this.authService.getAuthUserByToken()
                    .then((retour) => {
                        that.tokenId = retour[0]['id'];
                        this.authService.removeAuthToken(this.tokenId);
                        delete this.currentUser;
                        //location.reload();
                    })
  }
}
