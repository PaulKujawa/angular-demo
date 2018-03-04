import {Component} from '@angular/core';

@Component({
    selector: 'app-nav-bar',
    template: `
        <nav class="app-nav">
            <mat-toolbar color="primary">
                <a mat-button
                   [routerLink]="'app_root_i18n'|appRoute">
                    @VeGains
                </a>

                <a mat-button
                        [routerLink]="'app_recipes'|appRoute">
                    {{ 'app.common.recipes'|appTrans }}
                </a>

                <a mat-button
                        [routerLink]="'app_dashboard'|appRoute">
                    {{ 'app.common.dashboard'|appTrans }}
                </a>
            </mat-toolbar>
        </nav>
    `,
})
export class NavBarComponent {
}
