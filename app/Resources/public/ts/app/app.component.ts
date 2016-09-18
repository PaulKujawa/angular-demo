import {Component} from '@angular/core';

@Component({
    selector: 'spa',
    template: `
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" 
                    data-toggle="collapse" data-target="#ba-navbar__collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="ba-navbar__collapse">
                    <ul class="nav navbar-nav text-capitalize">
                        <li routerLinkActive="active" [routerLinkActiveOptions]="{exact: true}">
                            <a [routerLink]="['/']">inquiry</a>
                        </li>
                        <li routerLinkActive="active">
                            <a [routerLink]="['/recipes']">recipes</a>
                        </li>
                    </ul>
                     <ul class="nav navbar-nav navbar-right">
                        <li><a class="text-capitalize">de</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="container" id="recipePage">
            <flash-messages></flash-messages>
            <router-outlet></router-outlet>
        </section>
    `
})
export class AppComponent {
    // TODO move navbar into core component
}
