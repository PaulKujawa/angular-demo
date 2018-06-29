import {ChangeDetectionStrategy, Component} from '@angular/core';
import {RecipeState} from 'app/recipe/service/recipe.state';
import {PageableState} from 'app/shared/model/pageable.state';
import {FilterState} from 'app/shared/service/filter.state';

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
