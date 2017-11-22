import {ChangeDetectionStrategy, Component} from '@angular/core';
import {FilterState} from '../../shared/service/filter.state';
import {ProductState} from '../service/product.state';

@Component({
    changeDetection: ChangeDetectionStrategy.OnPush,
    providers: [FilterState, ProductState],
    template: `
        <router-outlet></router-outlet>
    `,
})
export class ProductComponent {
}
