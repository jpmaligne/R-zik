import { Component, OnInit, ViewChild } from '@angular/core';
import { AuthService, SongService } from '../services/index';
import { environment } from '../../environments/environment';   // Conf file
import { User } from '../models/user';
import { Song } from '../models/song';

@Component({
  selector: 'app-myaccount',
  templateUrl: './myaccount.component.html',
  styleUrls: ['./myaccount.component.css'],
  providers: [AuthService, SongService]
})
export class MyaccountComponent implements OnInit {
  private currentUser: User;
  private songTitle: string;
  private songDescription: string;
  private explicitContent: boolean;
  private downloadAuthorization: boolean;
  private length: number = 1;
  private data;
  private musicFolder = environment.apiEndpoint + environment.musicFolder;
  private mySongs: Song[];
  @ViewChild('fileInput') fileInput;

  constructor(private authService: AuthService, private songService: SongService) { }

  ngOnInit() {
    if(localStorage.getItem('auth-tokens')) {
      this.getUserByToken();
    }
  }

  getUserByToken() {
    var that = this;
    this.authService.getAuthUserByToken()
                    .then((retour) => {
                      that.currentUser = retour[0]['user'] as User;
                      this.songService.getUserSongs(that.currentUser.id)
                                      .then((retour) => {
                                        that.mySongs = retour as Song[];
                                      });
                    })
  }

  upload() {
    let fileBrowser = this.fileInput.nativeElement;
    if (fileBrowser.files && fileBrowser.files[0]) {
      let file: File = fileBrowser.files[0];
      console.log(file);
      const formData: FormData = new FormData();
      formData.append(this.songTitle, file);
      this.songService.uploadFile(formData)
        .then((retour)=>{
          this.postSong();
        });
    }
  }

  postSong() {
    //TODO TYPE OF SONG
    if(this.explicitContent === undefined) {
      this.explicitContent = false;
    }
    if(this.downloadAuthorization === undefined) {
      this.downloadAuthorization = false;
    }
    this.data = { 'title': this.songTitle,
                  'description': this.songDescription,
                  'artist': this.currentUser.id,
                  'explicitContent': this.explicitContent,
                  'downloadAuthorization': this.downloadAuthorization,
                  'createdAt': null,
                  'typeId': 0,
                  'length': this.length }
    this.songService.postSong(this.data);
  }

  changePlayerSource(songTitle){
    var player = document.getElementById('audio-player');
    player.setAttribute('src', environment.apiEndpoint + environment.musicFolder + songTitle + '.mp3')
    var player_source = document.getElementById('audio-player-source');
    player_source.setAttribute('src', environment.apiEndpoint + environment.musicFolder + songTitle);
    var evt = document.createEvent("MouseEvents");
    evt.initMouseEvent("click", true, true, window,0, 0, 0, 0, 0, false, false, false, false, 0, null);
    document.querySelector('[aria-label="Play/Pause"]').dispatchEvent(evt);
  }
}
