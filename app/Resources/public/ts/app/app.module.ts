import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {CoreModule} from "./core/core.module";
import {InquiryModule} from "./inquiry/inquiry.module";
import {RecipeModule} from "./recipe/recipe.module";
import {AppRoutingModule} from "./app-routing.module";
import {SharedModule} from "./shared/shared.module";
import {AuthModule} from "./auth/auth.module";
import {ProductModule} from "./product/product.module";

@NgModule({
    imports: [
        AuthModule,
        AppRoutingModule,
        BrowserModule,
        CoreModule,
        SharedModule,
        InquiryModule,
        ProductModule,
        RecipeModule,
    ],
    declarations: [AppComponent],
    exports: [AppComponent],
    bootstrap: [AppComponent],
})
export class AppModule {}
