import {Component} from '@angular/core';

@Component({
    selector: 'nav-bar',
    template: `
        <nav class="app-nav">
            <mat-toolbar color="primary">
                <a mat-button
                   [routerLink]="'app_root_i18n'|route">
                    @VeGains
                </a>

                <a mat-button
                        [routerLink]="'app_recipes'|route">
                    {{ 'app.common.recipes'|trans }}
                </a>

                <a mat-button
                        [routerLink]="'app_products'|route">
                    {{ 'app.common.products'|trans }}
                </a>
            </mat-toolbar>
        </nav>
    `,
})
export class NavBarComponent {
}
