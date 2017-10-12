import { Component } from '@angular/core';
import {UsersService, PlaylistService, AuthService } from '../services/index';
import { URLSearchParams, Response, Http, Headers } from '@angular/http';

@Component({
    templateUrl: '../views/playlist.component.html',
    styleUrls: ['../styles/users.component.css'],
    providers: [UsersService, PlaylistService, AuthService]
})

export class PlaylistComponent {
    title = 'Gérer mes Playlists';
    users;
    idUser;
    playlists;

    constructor(private usersService: UsersService, private playlistService: PlaylistService, private authService: AuthService) {
        this.authService.getAuthUserByToken().then((response) => {this.idUser = response[0].user.id}).then((response) =>
        this.playlistService.getPlaylists(this.idUser).then((response) => this.playlists = response));
    }
}