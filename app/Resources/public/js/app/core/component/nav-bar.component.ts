import {Component} from '@angular/core';

@Component({
    selector: 'nav-bar',
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
                        [routerLink]="'app_products'|appRoute">
                    {{ 'app.common.products'|appTrans }}
                </a>
            </mat-toolbar>
        </nav>
    `,
})
export class NavBarComponent {
}
