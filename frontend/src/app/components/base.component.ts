import { Component, OnInit } from '@angular/core';

declare var soundManager: any;
declare var sm2BarPlayers: any;

@Component({
  selector: 'app-root',
  templateUrl: '../views/base.component.html'
  //styleUrls: ['../../assets/soundmanager2/styles/bar-ui.css']
})
export class BaseComponent implements OnInit {
  ngOnInit() {
    soundManager.setup({
      url: '../../../node_modules/soundmanager2/swf/soundmanager2.swf',
      debugMode: true,
      onready: function() {
        var mySound = soundManager.createSound({
          id: 'aSound',
          url: 'http://developer.mozilla.org/@api/deki/files/2926/=AudioTest_(1).ogg'
        });
        mySound.play();
      },
      ontimeout: function() {
        // Hrmm, SM2 could not start. Missing SWF? Flash blocked? Show an error, etc.?
      }
    });

    var stylesheet = document.createElement('link');
    stylesheet.href = '../../assets/soundmanager2/styles/bar-ui.css';
    stylesheet.rel = 'stylesheet';
    stylesheet.type = 'text/css';
    document.getElementsByTagName('head')[0].appendChild(stylesheet);
  }
  title = 'R-zik';

  
}