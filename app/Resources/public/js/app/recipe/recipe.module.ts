import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {MatCardModule} from '@angular/material/card';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatInputModule} from '@angular/material/input';
import {RecipeDetailComponent} from 'app/recipe/component/recipe-detail.component';
import {RecipeFactsComponent} from 'app/recipe/component/recipe-facts.component';
import {RecipeFilterComponent} from 'app/recipe/component/recipe-filter.component';
import {RecipeListComponent} from 'app/recipe/component/recipe-list.component';
import {RecipeComponent} from 'app/recipe/component/recipe.component';
import {RecipeRoutingModule} from 'app/recipe/recipe-routing.module';
import {RecipeRepository} from 'app/recipe/repository/recipe.repository';
import {RecipeState} from 'app/recipe/service/recipe.state';
import {SharedModule} from 'app/shared/shared.module';

@NgModule({
    imports: [
        CommonModule,
        MatCardModule,
        MatCheckboxModule,
        MatInputModule,
        FormsModule,
        SharedModule,
        RecipeRoutingModule,
    ],
    declarations: [
        RecipeComponent,
        RecipeDetailComponent,
        RecipeFactsComponent,
        RecipeFilterComponent,
        RecipeListComponent,
    ],
    exports: [],
    providers: [
        RecipeState,
        RecipeRepository,
    ],
})
export class RecipeModule {
}
