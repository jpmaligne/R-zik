import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule }   from '@angular/router';
import { HttpModule }    from '@angular/http';
import { BaseComponent } from './components/base.component';
import { UsersComponent } from './components/users.component';
import { LoginComponent } from './components/login.component';

@NgModule({
  imports: [
    BrowserModule,
    HttpModule,
    RouterModule.forRoot([
      {
        path: 'users',
        component: UsersComponent
      },
      {
        path: 'login',
        component: LoginComponent
      }
    ])
  ],
  declarations: [
    BaseComponent,
    UsersComponent,
    LoginComponent
  ],
  providers: [],
  bootstrap: [BaseComponent]
})
export class AppModule { }
