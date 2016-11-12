import {Component} from '@angular/core';

@Component({
    selector: 'spa',
    template: `
        <nav-bar></nav-bar>

        <section class="container" id="recipePage">
            <flash-messages></flash-messages>
            <router-outlet></router-outlet>
        </section>
    `
})
export class AppComponent {}
