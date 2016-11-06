import {Component} from '@angular/core';
import {FlashMessage} from "../model/flash-message";
import {FlashMessageService} from "../service/flash-message.service";

@Component({
    selector: 'nav-bar',
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
                <div id="ba-navbar__collapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav text-capitalize">
                        <li routerLinkActive="active" [routerLinkActiveOptions]="{exact: true}">
                            <a [routerLink]="['/']">{{'app.inquiry.inquiry'|trans}}</a>
                        </li>
                        <li routerLinkActive="active">
                            <a [routerLink]="['/recipes']">{{'app.recipe.recipes'|trans}}</a>
                        </li>
                    </ul>
                     <ul class="nav navbar-nav navbar-right">
                        <!--<li><a class="text-capitalize">de</a></li>-->
                    </ul>
                </div>
            </div>
        </nav>
    `
})
export class NavBarComponent {}
