import {NgModule} from "@angular/core";
import {RouterModule} from "@angular/router";
import {InquiryComponent} from "./inquiry/component/inquiry.component";
import {RecipesComponent} from "./recipe/component/recipes.component";
import {RecipeComponent} from "./recipe/component/recipe.component";

@NgModule({
    imports: [
        RouterModule.forRoot([
            {path: '', component: InquiryComponent},
            {path: 'recipes', component: RecipesComponent},
            {path: 'recipes/:id/:name', component: RecipeComponent},
        ])
    ],
    exports: [RouterModule]
})
export class AppRoutingModule {}
