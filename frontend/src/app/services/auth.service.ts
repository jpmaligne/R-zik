import { Injectable } from '@angular/core';
import { Headers, Http, RequestOptions } from '@angular/http';
import { environment } from '../../environments/environment';   // Conf file

import 'rxjs/add/operator/toPromise'

@Injectable()
export class AuthService {
  private headers = new Headers({'Content-Type': 'application/json'});
  private authTokenUrl = environment.apiEndpoint + 'auth-tokens';
  constructor(private http: Http) { };

  getAuthUserByToken(): Promise<any> {
    var options = this.initOptionHeader();
    console.log(options);
    return this.http.get(this.authTokenUrl, options).toPromise()
                    .then(response => response.json())
                    .catch(this.errorHandler);
  }
  getAuthToken(login, password): Promise<any> {
    return this.http.post(this.authTokenUrl , { 'login': login, 'password': password })
                    .toPromise()
                    .then(response => response.json())
                    .catch(this.errorHandler);
  }
  removeAuthToken(tokenId): Promise<any> {
    var options = this.initOptionHeader();
    return this.http.delete(this.authTokenUrl + '/' + tokenId, options).toPromise()
                    .then((response) => {
                        response.json();
                        localStorage.removeItem('auth-tokens');
                    })
                   .catch(this.errorHandler);
  }
  private errorHandler(err: any): Promise<any> {
    return Promise.reject(err.message || err );
  };

 initOptionHeader() {
   let headers = new Headers();
   var token: any = localStorage.getItem('auth-tokens');
   headers.append('Content-Type', 'application/json');
   headers.append('X-Auth-Token', token);
   let options = new RequestOptions({ headers: headers });
   return options;
 }
}