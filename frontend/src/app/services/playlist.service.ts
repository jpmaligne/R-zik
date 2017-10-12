import { URLSearchParams, Response, Http, Headers } from '@angular/http';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';   // Conf file
import { AuthService } from '../services/auth.service';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class PlaylistService{

    results: string[];
    private headers = new Headers({'Content-Type': 'application/json'});
    private url = environment.apiEndpoint + "playlist";            // Use url in conf file
    constructor(private http: Http, private authService: AuthService) {}

    getPlaylists(id): Promise<string[]> {

        return this.http
            .get(this.url + 's/'+id, this.authService.initOptionHeader())
            .toPromise()
            .then(response => response.json())
            .catch(this.handleError);
    }

    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error);              // For demo purposes only
        return Promise.reject(error.message || error);
    }
}