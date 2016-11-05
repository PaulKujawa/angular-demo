import {NgModule} from '@angular/core';
import {CommonModule} from "@angular/common";
import {RecipeRepository} from "./repository/recipe.repository";
import {RecipesComponent} from "./component/recipes.component";
import {RecipeComponent} from "./component/recipe.component";
import {SharedModule} from "../shared/shared.module";
import {FilterComponent} from "./component/filter.component";

@NgModule({
    imports: [
        CommonModule,
        SharedModule,
    ],
    declarations: [
        FilterComponent,
        RecipesComponent,
        RecipeComponent,
    ],
    exports: [],
    providers: [
        RecipeRepository,
    ]
})
export class RecipeModule {}
