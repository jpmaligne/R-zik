import { URLSearchParams, Response, Http, Headers } from '@angular/http';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class LoginService{

    results: string[];
    private headers = new Headers({'Content-Type': 'application/json'});
    private baseUrl = "http://localhost/projects/R-zik/web/";
    constructor(private http: Http) {}

    getId(): Promise<string[]> {
        return this.http
                    .get(this.baseUrl+"login")
                    .toPromise()
                    .then(response => response.json())
                    .catch(this.handleError);
        }
    
    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error); // for demo purposes only
        return Promise.reject(error.message || error);
    }
}