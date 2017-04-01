import {Component} from '@angular/core';

@Component({
    selector: 'nav-bar',
    template: `
         <nav class="navbar navbar-inverse">
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
                            <a [routerLink]="'app_root_i18n'|route|trimBaseUrl">
                                {{'app.inquiry.inquiry'|trans}}
                            </a>
                        </li>
                        <li routerLinkActive="active">
                            <a [routerLink]="'app_recipes'|route|trimBaseUrl">
                                {{'app.common.recipes'|trans}}
                            </a>
                        </li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {{'app.common.cms'|trans}}<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li routerLinkActive="active">
                                    <a [routerLink]="'app_products'|route|trimBaseUrl">
                                        {{'app.common.products'|trans}}
                                    </a>
                                </li>
                            </ul>
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
