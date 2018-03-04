import {ChangeDetectionStrategy, Component} from '@angular/core';

@Component({
    changeDetection: ChangeDetectionStrategy.OnPush,
    template: `
        <router-outlet></router-outlet>
    `,
})
export class StartPageComponent {
}
