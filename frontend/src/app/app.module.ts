import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule }   from '@angular/router';
import { HttpModule }    from '@angular/http';
import { BaseComponent } from './components/base.component';
import { BaseComponent2 } from './components/base.component2';
import { UsersComponent } from './components/users.component';
import { LoginComponent } from './login/login.component';
import { PlaylistComponent } from './components/playlist.component';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { HomeComponent } from './home/home.component';
import { UserComponent } from './user/user.component';
import { RegisterComponent } from './register/register.component';

@NgModule({
  imports: [
    BrowserModule,
    CommonModule,
    HttpModule,
    FormsModule,
    RouterModule.forRoot([
      {
        path: '',
        component: HomeComponent
      },
      {
        path: 'users',
        component: UsersComponent
      },
      {
        path: 'user/:id',
        component: UserComponent
      },
      {
        path: 'login',
        component: LoginComponent
      },
      {
        path: 'playlist',
        component: PlaylistComponent
      }
    ])
  ],
  declarations: [
    // BaseComponent,
    BaseComponent2,
    UsersComponent,
    LoginComponent,
    HomeComponent,
    UserComponent,
    PlaylistComponent,
    RegisterComponent
  ],
  providers: [],
  bootstrap: [BaseComponent2]
})
export class AppModule { 

}
