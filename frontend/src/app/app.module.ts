import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule }   from '@angular/router';
import { HttpModule }    from '@angular/http';

import { AppComponent } from './app.component';
import { UsersComponent } from './components/users.component';

@NgModule({
  imports: [
    BrowserModule,
    HttpModule,
    RouterModule.forRoot([
      {
        path: 'users',
        component: UsersComponent
      }
    ])
  ],
  declarations: [
    AppComponent,
    UsersComponent
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
