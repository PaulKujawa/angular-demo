import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";
import {RecipeComponent} from "./component/recipe.component";
import {RecipesComponent} from "./component/recipes.component";

@NgModule({
    imports: [
        RouterModule.forChild([
            {path: 'recipes', component: RecipesComponent},
            {path: 'recipes/:id/:name', component: RecipeComponent},
        ])
    ],
    exports: [RouterModule]
})
export class RecipeRoutingModule {}
