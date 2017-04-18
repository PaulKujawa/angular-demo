import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {RecipeRepository} from './repository/recipe.repository';
import {SharedModule} from '../shared/shared.module';
import {RecipeFilterComponent} from './component/recipe-filter.component';
import {RecipeRoutingModule} from './recipe-routing.module';
import {MacroChartComponent} from './component/macro-chart.component';
import {RecipeDetailComponent} from './component/recipe-detail.component';
import {RecipeListComponent} from './component/recipe-list.component';
import {RecipeComponent} from './component/recipe.component';

@NgModule({
    imports: [
        CommonModule,
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
export class RecipeModule {}
