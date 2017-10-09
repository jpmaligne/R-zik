import { Component, OnInit } from '@angular/core';
import { UserService } from '../services/index';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [UserService]
})
export class RegisterComponent implements OnInit {

  private login: string;
  private mail: string;
  private password: string;
  private firstname: string;
  private lastname: string;
  private data: {};
  private registerError;
  private registerSuccess;
  constructor(private userService:UserService) {
    this.registerError = "";
    this.registerSuccess = "";
  }

  ngOnInit() {
  }

  createUser() {
    this.registerError = "";
    this.registerSuccess = "";
    this.data = { 'login': this.login, 'email': this.mail, 'plainPassword': this.password,
    'firstname': this.firstname, 'lastname': this.lastname}
    let postError;
    this.userService.postUser(this.data)
                    .then((response:any) => this.registerSuccess = "Vous pouvez maintenant vous connecter")
                    .catch((error) => this.handleError(this, error)) ;
  }
  handleError(that, error: any): void {
    if (error.status == 400) {
      error = JSON.parse(error._body);
      let errors = error.errors.children;
      for (let key in errors) {
        if (errors[key]["errors"] !== undefined) {
          that.registerError = key + " : " + errors[key]["errors"][0];
        }
      }
    }
  }

}
