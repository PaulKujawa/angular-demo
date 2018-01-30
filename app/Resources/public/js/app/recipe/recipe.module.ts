import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {MatCardModule} from '@angular/material/card';
import {MatCheckboxModule} from '@angular/material/checkbox';
import {MatInputModule} from '@angular/material/input';
import {MatListModule} from '@angular/material/list';
import {MatTabsModule} from '@angular/material/tabs';
import {SharedModule} from '../shared/shared.module';
import {RecipeDetailComponent} from './component/recipe-detail.component';
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
        MatListModule,
        MatTabsModule,
        FormsModule,
        SharedModule,
        RecipeRoutingModule,
    ],
    declarations: [
        RecipeComponent,
        RecipeDetailComponent,
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
