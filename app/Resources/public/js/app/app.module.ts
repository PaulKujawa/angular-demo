import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {CoreModule} from './core/core.module';
import {DashboardModule} from './dashboard/dashboard.module';
import {ProductModule} from './product/product.module';
import {RecipeModule} from './recipe/recipe.module';
import {SharedModule} from './shared/shared.module';

@NgModule({
    imports: [
        AppRoutingModule,
        BrowserAnimationsModule,
        BrowserModule,
        CoreModule,
        DashboardModule,
        SharedModule,
        ProductModule,
        RecipeModule,
    ],
    declarations: [AppComponent],
    exports: [AppComponent],
    bootstrap: [AppComponent],
})
export class AppModule {}
