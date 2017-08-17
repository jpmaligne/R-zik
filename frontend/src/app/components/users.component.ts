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
  id;

  constructor(private usersService: UsersService) {
    usersService.getId().then(data => this.id = data);
  }
}
