import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {CoreModule} from './core/core.module';
import {DashboardModule} from './dashboard/dashboard.module';
import {RecipeModule} from './recipe/recipe.module';
import {SharedModule} from './shared/shared.module';

@NgModule({
    imports: [
        // Lazy loaded modules will be loaded by ngtools/webpack, that resolves app-routing.module.ts
        AppRoutingModule,
        BrowserAnimationsModule,
        BrowserModule,
        CoreModule,
        DashboardModule,
        SharedModule,
        RecipeModule,
    ],
    declarations: [AppComponent],
    exports: [AppComponent],
    bootstrap: [AppComponent],
})
export class AppModule {
}
