import { Component } from '@angular/core';
import { LoginService } from '../services/login.service';
import { URLSearchParams, Response, Http, Headers } from '@angular/http';

@Component({
  templateUrl: '../views/login.component.html',
  //styleUrls: ['../styles/login.component.css'],
  providers: [LoginService]
})
export class LoginComponent {
  title = 'login';
  id;

  constructor(private loginService: LoginService) {
    loginService.getId().then(data => this.id = data);
  }
}
