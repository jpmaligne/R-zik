import { Injectable } from '@angular/core';
import { Headers, Http, RequestOptions } from '@angular/http';
import { AuthService } from '../services/auth.service';
import { environment } from '../../environments/environment';   // Conf file
import { Song } from '../models/song';
import 'rxjs/add/operator/toPromise'

@Injectable()
export class SongService {
  private songUrl = environment.apiEndpoint + 'song'
  private songsUrl = environment.apiEndpoint + 'songs'
  constructor(private http: Http, private authService: AuthService) {}

  uploadFile(data): Promise<any>{
    var options = this.initOptionHeaderfile();
    return this.http.post(this.songUrl + '/uploadFile', data, options).toPromise()
      .then(response => response.json())
      .catch(this.handleError);
  }

  postSong(data): Promise<string[]> {
    return this.http
                .post(this.songUrl, data)
                .toPromise()
                .then(response => response.json())
                .catch(this.handleError);
    }

  getUserSongs(user_id): Promise<Song[]> {
    return this.http
               .get(this.songsUrl + "/user/" + user_id, this.authService.initOptionHeader())
               .toPromise()
               .then(response => response.json())
               .catch(this.handleError);
  }

  private initOptionHeaderfile(){
    let headers = new Headers();
    let token: any = localStorage.getItem('auth-tokens');
    headers.append('X-Auth-Token', token);
    headers.append('enctype','multipart/form-data');
    let options = new RequestOptions({ headers: headers });
    return options;
  }

  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error); // for demo purposes only
    return Promise.reject(error.message || error);
  }
}