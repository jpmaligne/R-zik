import { Component, OnInit } from '@angular/core';
import { UserService, AuthService, SongService } from '../services/index';
import {Router, ActivatedRoute, Params} from '@angular/router';
import { environment } from '../../environments/environment';   // Conf file
import { Song } from '../models/song';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css'],
  providers: [UserService, AuthService, SongService]
})
export class UserComponent {
  private id: number;
  private user: any;
  private mySongs: any;

  constructor(private activatedRoute: ActivatedRoute, private userService: UserService, private songService: SongService) {
    this.activatedRoute.params.subscribe((params: Params) => {
      this.id = params['id'];
      this.userService.getUser(this.id).then((response) => {this.user = response; 
                                                            console.log(this.user);
                                                            this.songService.getUserSongs(this.user.id)
                                                            .then((retour) => {
                                                              this.mySongs = retour as Song[];
                                                            });
                                                          });
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

  changePlayerSourceMusic(songTitle){
    var player = document.getElementById('audio-player');
    player.setAttribute('src', environment.apiEndpoint + environment.musicFolder + songTitle + '.mp3')
    var player_source = document.getElementById('audio-player-source');
    player_source.setAttribute('src', environment.apiEndpoint + environment.musicFolder + songTitle);
    var evt = document.createEvent("MouseEvents");
    evt.initMouseEvent("click", true, true, window,0, 0, 0, 0, 0, false, false, false, false, 0, null);
    document.querySelector('[aria-label="Play/Pause"]').dispatchEvent(evt);
  }
}
