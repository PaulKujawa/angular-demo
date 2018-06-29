import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {RecipeDetailComponent} from 'app/recipe/component/recipe-detail.component';
import {RecipeListComponent} from 'app/recipe/component/recipe-list.component';
import {RecipeComponent} from 'app/recipe/component/recipe.component';

const recipeRoutes: Routes = [
    {
        path: '',
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
