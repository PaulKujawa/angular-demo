import {ChangeDetectionStrategy, Component} from '@angular/core';
import {PageableState} from '../../shared/model/pageable.state';
import {FilterState} from '../../shared/service/filter.state';
import {RecipeState} from '../service/recipe.state';

@Component({
    changeDetection: ChangeDetectionStrategy.OnPush,
    providers: [
        FilterState,
        RecipeState,
        {provide: PageableState, useExisting: RecipeState},
    ],
    template: `
        <router-outlet></router-outlet>
    `,
})
export class RecipeComponent {
}
