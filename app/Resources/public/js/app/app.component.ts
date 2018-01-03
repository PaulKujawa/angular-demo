import {ChangeDetectionStrategy, Component} from '@angular/core';

@Component({
    selector: 'spa',
    changeDetection: ChangeDetectionStrategy.OnPush,
    template: `
        <nav-bar></nav-bar>

        <section class="app-section">
            <router-outlet></router-outlet>
        </section>
    `,
})
export class AppComponent {
}
