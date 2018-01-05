import {ChangeDetectionStrategy, Component} from '@angular/core';

@Component({
    selector: 'app-spa',
    changeDetection: ChangeDetectionStrategy.OnPush,
    template: `
        <app-nav-bar></app-nav-bar>

        <section class="app-section">
            <router-outlet></router-outlet>
        </section>
    `,
})
export class AppComponent {
}
