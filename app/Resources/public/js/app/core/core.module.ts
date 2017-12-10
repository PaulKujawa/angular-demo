import {CommonModule} from '@angular/common';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {RouterModule} from '@angular/router';
import {SharedModule} from '../shared/shared.module';
import {AuthComponent} from './component/auth.component';
import {NavBarComponent} from './component/nav-bar.component';
import {
    AuthenticatedInjectToken,
    BaseUrlInjectToken,
    FosRouterInjectToken,
    RequestLocaleInjectToken,
    TranslatorInjectToken,
    WindowInjectToken,
} from './core.token';
import {PageableFactory} from './factory/pageable.factory';
import {AuthRepository} from './repository/auth.repository';
import {AuthenticationGuard} from './service/auth-guard.service';
import {AuthenticationService} from './service/authentication.service';
import {FlashMessageInterceptor} from './service/flash-message.interceptor';
import {FlashMessageService} from './service/flash-message.service';
import {HeadersInterceptor} from './service/headers.interceptor';
import {InViewportService} from './service/in-viewport.service';
import {RoutingService} from './service/routing.service';
import {TranslationService} from './service/translation.service';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        HttpClientModule,
        MatSnackBarModule,
        SharedModule,
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
        AuthenticationGuard,
        AuthenticationService,
        AuthRepository,
        InViewportService,
        FlashMessageService,
        PageableFactory,
        RoutingService,
        TranslationService,
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
