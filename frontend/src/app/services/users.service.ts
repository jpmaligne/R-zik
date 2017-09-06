import { URLSearchParams, Response, Http, Headers } from '@angular/http';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';   // Conf file
import 'rxjs/add/operator/toPromise';

@Injectable()
export class UsersService{

    results: string[];
    private headers = new Headers({'Content-Type': 'application/json'});
    private url = environment.apiEndpoint + "users";            // Use url in conf file
    constructor(private http: Http) {}

    getId(): Promise<string[]> {
        return this.http
                    .get(this.url)
                    .toPromise()
                    .then(response => response.json())
                    .catch(this.handleError);
        }
    
    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error);              // For demo purposes only
        return Promise.reject(error.message || error);
    }
}