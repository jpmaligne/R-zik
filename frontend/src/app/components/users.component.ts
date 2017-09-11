import { Component } from '@angular/core';
import { UsersService } from '../services/users.service';
import { URLSearchParams, Response, Http, Headers } from '@angular/http';

@Component({
  templateUrl: '../views/users.component.html',
  styleUrls: ['../styles/users.component.css'],
  providers: [UsersService]
})
export class UsersComponent {
  title = 'users';
  users;

  constructor(private usersService: UsersService) {
    usersService.getUsers().then(data => this.users = data);
  }
}
