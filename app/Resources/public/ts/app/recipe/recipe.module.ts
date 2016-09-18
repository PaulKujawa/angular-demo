import {NgModule} from '@angular/core';
import {CommonModule} from "@angular/common";
import {RecipeRepository} from "./repository/recipe.repository";
import {RecipesComponent} from "./component/recipes.component";
import {RecipeComponent} from "./component/recipe.component";

@NgModule({
    imports: [
        CommonModule,
    ],
    declarations: [
        RecipesComponent,
        RecipeComponent,
    ],
    exports: [],
    providers: [
        RecipeRepository,
    ]
})
export class RecipeModule {}
