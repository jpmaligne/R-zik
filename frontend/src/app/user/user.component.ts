import { Component, OnInit } from '@angular/core';
import { UserService, AuthService } from '../services/index';
import {Router, ActivatedRoute, Params} from '@angular/router';
import { environment } from '../../environments/environment';   // Conf file

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

  changePlayerSource(){
      var player = document.getElementById('audio-player');
      player.setAttribute('src', environment.streamEndpoint + "user-" + this.user.id)
      var player_source = document.getElementById('audio-player-source');
      player_source.setAttribute('src', environment.streamEndpoint + "user-" + this.user.id);
      var evt = document.createEvent("MouseEvents");
      evt.initMouseEvent("click", true, true, window,0, 0, 0, 0, 0, false, false, false, false, 0, null);
      document.querySelector('[aria-label="Play/Pause"]').dispatchEvent(evt);      
      
  }
}
