import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {RecipeComponent} from './component/recipe.component';
import {RecipeListComponent} from './component/recipe-list.component';
import {RecipeDetailComponent} from './component/recipe-detail.component';

const recipeRoutes: Routes = [
    {
        path: 'pageable',
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
export class RecipeRoutingModule {}
