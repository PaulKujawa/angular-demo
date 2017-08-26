import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {SharedModule} from '../shared/shared.module';
import {MacroChartComponent} from './component/macro-chart.component';
import {RecipeDetailComponent} from './component/recipe-detail.component';
import {RecipeFilterComponent} from './component/recipe-filter.component';
import {RecipeListComponent} from './component/recipe-list.component';
import {RecipeComponent} from './component/recipe.component';
import {RecipeRoutingModule} from './recipe-routing.module';
import {RecipeRepository} from './repository/recipe.repository';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        SharedModule,
        RecipeRoutingModule,
    ],
    declarations: [
        MacroChartComponent,
        RecipeComponent,
        RecipeDetailComponent,
        RecipeFilterComponent,
        RecipeListComponent,
    ],
    exports: [],
    providers: [
        RecipeRepository,
    ],
})
export class RecipeModule {
}
