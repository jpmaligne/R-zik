import { Component } from '@angular/core';
import { UsersService } from '../services/users.service';
import { AuthService } from '../services/auth.service';
import { URLSearchParams, Response, Http, Headers } from '@angular/http';

@Component({
  templateUrl: '../views/users.component.html',
  styleUrls: ['../styles/users.component.css'],
  providers: [UsersService, AuthService]
})
export class UsersComponent {
  title = 'users';
  users;
  currentUser: string = '';

  constructor(private usersService: UsersService, private authService: AuthService) {
    this.authService.getAuthUserByToken().then((response) => this.currentUser = response[0].user);
    this.usersService.getUsers().then((response) => this.users = response);
  }
}
