import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {AppRoutingModule} from 'app/app-routing.module';
import {AppComponent} from 'app/app.component';
import {CoreModule} from 'app/core/core.module';
import {StartPageModule} from 'app/start-page/start-page.module';

@NgModule({
    imports: [
        // Lazy loaded modules will be loaded by ngtools/webpack, that resolves app-routing.module.ts
        AppRoutingModule,
        BrowserAnimationsModule,
        BrowserModule,
        CoreModule,
        StartPageModule,
    ],
    declarations: [AppComponent],
    exports: [AppComponent],
    bootstrap: [AppComponent],
})
export class AppModule {
}
