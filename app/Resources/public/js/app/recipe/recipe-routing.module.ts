import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {RecipeDetailComponent} from './component/recipe-detail.component';
import {RecipeListComponent} from './component/recipe-list.component';
import {RecipeComponent} from './component/recipe.component';

const recipeRoutes: Routes = [
    {
        path: 'recipes',
        component: RecipeComponent,
        children: [
            {
                path: ':id/:name',
                component: RecipeDetailComponent,
            },
            {
                path: '',
                component: RecipeListComponent,
            },
        ],
    },
];

@NgModule({
    imports: [
        RouterModule.forChild(recipeRoutes),
    ],
    exports: [RouterModule],
})
export class RecipeRoutingModule {
}
