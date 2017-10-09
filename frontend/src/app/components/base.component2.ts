import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/index';
import { User } from '../models/user';

declare var soundManager: any;
declare var jquery:any;
declare var $ :any;
declare var UISearch: any;

@Component({
  selector: 'app-root',
  templateUrl: '../views/base.component2.html',
  providers: [AuthService]
})
export class BaseComponent2 implements OnInit {
    currentUser: User;
    tokenId: Number;
    constructor(private authService: AuthService) { };
    title = 'RZik - Go ahead ! Everysing is in the bass';
    ngOnInit(){
        console.log('init');
        if(localStorage.getItem('auth-tokens')) {
          this.getUserByToken();
        }
        new UISearch(document.getElementById('sb-search'));
    }




  /*A voir apres*/
    //   ngOnInit() {
    
    //     if(localStorage.getItem('auth-tokens')) {
    //       this.getUserByToken();
    //     }
    
    //     //We load css after js is loaded
    //     var stylesheet = document.createElement('link');
    //     stylesheet.href = '../../assets/soundmanager2/styles/bar-ui.css';
    //     stylesheet.rel = 'stylesheet';
    //     stylesheet.type = 'text/css';
    //     document.getElementsByTagName('head')[0].appendChild(stylesheet);
    //   }
  getUserByToken() {
    var that = this;
    this.authService.getAuthUserByToken()
                    .then((retour) => {
                      that.currentUser = retour[0]['user'] as User;
                      console.log(that.currentUser);
                    })
  }
  disconnect() {
    var that = this;
    this.authService.getAuthUserByToken()
                    .then((retour) => {
                        that.tokenId = retour[0]['id'];
                        this.authService.removeAuthToken(this.tokenId);
                        localStorage.removeItem('auth-tokens');
                        delete this.currentUser;
                        location.reload();
                    })
  }
  /*Fin a voir apres*/
}
