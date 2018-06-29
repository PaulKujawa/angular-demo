import {CommonModule} from '@angular/common';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {NgModule} from '@angular/core';
import {ReactiveFormsModule} from '@angular/forms';
import {MatButtonModule} from '@angular/material/button';
import {MatInputModule} from '@angular/material/input';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatToolbarModule} from '@angular/material/toolbar';
import {RouterModule} from '@angular/router';
import {AuthComponent} from 'app/core/component/auth.component';
import {NavBarComponent} from 'app/core/component/nav-bar.component';
import {
    AuthenticatedInjectToken,
    BaseUrlInjectToken,
    FosRouterInjectToken,
    RequestLocaleInjectToken,
    TranslatorInjectToken,
    WindowInjectToken,
} from 'app/core/core.token';
import {FlashMessageInterceptor} from 'app/core/service/flash-message.interceptor';
import {HeadersInterceptor} from 'app/core/service/headers.interceptor';
import {SharedModule} from 'app/shared/shared.module';

@NgModule({
    imports: [
        CommonModule,
        HttpClientModule,
        MatButtonModule,
        MatInputModule,
        MatSnackBarModule,
        MatToolbarModule,
        SharedModule,
        ReactiveFormsModule,
        RouterModule,
    ],
    declarations: [
        AuthComponent,
        NavBarComponent,
    ],
    exports: [
        NavBarComponent,
    ],
    providers: [
        {provide: HTTP_INTERCEPTORS, useClass: HeadersInterceptor, multi: true},
        {provide: HTTP_INTERCEPTORS, useClass: FlashMessageInterceptor, multi: true},
        {provide: AuthenticatedInjectToken, useFactory: () => window.appInject.authenticated},
        {provide: BaseUrlInjectToken, useFactory: () => window.appInject.baseUrl},
        {provide: FosRouterInjectToken, useFactory: () => window.Routing},
        {provide: RequestLocaleInjectToken, useFactory: () => window.appInject.requestLocale},
        {provide: TranslatorInjectToken, useFactory: () => Translator},
        {provide: WindowInjectToken, useFactory: () => window},
    ],
})
export class CoreModule {
}
