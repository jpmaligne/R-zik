import { Component } from '@angular/core';
import { AuthService } from '../services/index';
import { URLSearchParams, Response, Http, Headers } from '@angular/http';

@Component({
  templateUrl: '../views/login.component.html',
  //styleUrls: ['../styles/login.component.css'],
  providers: [AuthService]
})
export class LoginComponent {
  title = 'login';
  login: string = '';
  password: string = '';
  response: string[] = [];

  constructor(private authService: AuthService) {
  }
  private doLogin() {
    this.authService.getAuthToken(this.login, this.password)
                    .then((response) => {
                      localStorage.setItem('auth-tokens', response['value']);
                      location.reload();
                    });
  }
}
