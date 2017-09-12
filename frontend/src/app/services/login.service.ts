import { URLSearchParams, Response, Http, Headers } from '@angular/http';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';   // Conf file
import 'rxjs/add/operator/toPromise';

@Injectable()
export class LoginService{

    results: string[];
    private headers = new Headers({'Content-Type': 'application/json'});
    private baseUrl = environment.apiEndpoint;
    constructor(private http: Http) {}

    createToken(data): Promise<string[]> {
        console.log(this.baseUrl);
        return this.http
                    .post(this.baseUrl+"auth-tokens", data)
                    .toPromise()
                    .then(response => response.json())
                    .catch(this.handleError);
        }

    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error); // for demo purposes only
        return Promise.reject(error.message || error);
    }
}