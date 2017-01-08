import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {RecipeComponent} from './component/recipe.component';
import {RecipesComponent} from './component/recipes.component';

const recipeRoutes: Routes = [
    {path: 'recipes', component: RecipesComponent},
    {path: 'recipes/:id/:name', component: RecipeComponent},
];

@NgModule({
    imports: [
        RouterModule.forChild(recipeRoutes),
    ],
    exports: [RouterModule]
})
export class RecipeRoutingModule {}
