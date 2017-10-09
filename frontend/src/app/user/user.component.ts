import { Component, OnInit } from '@angular/core';
import { UserService, AuthService } from '../services/index';
import {Router, ActivatedRoute, Params} from '@angular/router';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css'],
  providers: [UserService, AuthService]
})
export class UserComponent {
  private id: number;
  private user: any;

  constructor(private activatedRoute: ActivatedRoute, private userService: UserService) {
    this.activatedRoute.params.subscribe((params: Params) => {
      this.id = params['id'];
      this.userService.getUser(this.id).then((response) => {this.user = response; console.log(this.user);});
    });
  }
}
