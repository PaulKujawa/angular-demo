import {ChangeDetectionStrategy, Component} from '@angular/core';
import {FilterState} from '../../shared/service/filter.state';
import {RecipeState} from '../service/recipe.state';
import {PageableState} from '../../shared/model/pageable.state';

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
