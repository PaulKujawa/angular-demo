import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {MatCardModule} from '@angular/material/card';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatInputModule} from '@angular/material/input';
import {SharedModule} from '../shared/shared.module';
import {RecipeDetailComponent} from './component/recipe-detail.component';
import {RecipeFactsComponent} from './component/recipe-facts.component';
import {RecipeFilterComponent} from './component/recipe-filter.component';
import {RecipeListComponent} from './component/recipe-list.component';
import {RecipeComponent} from './component/recipe.component';
import {RecipeRoutingModule} from './recipe-routing.module';
import {RecipeRepository} from './repository/recipe.repository';
import {RecipeState} from './service/recipe.state';

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
