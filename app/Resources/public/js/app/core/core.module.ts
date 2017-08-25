import {CommonModule} from '@angular/common';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {RouterModule} from '@angular/router';
import {SharedModule} from '../shared/shared.module';
import {AuthComponent} from './component/auth.component';
import {FlashMessageComponent} from './component/flash-message.component';
import {NavBarComponent} from './component/nav-bar.component';
import {PageableFactory} from './factory/pageable.factory';
import {AuthRepository} from './repository/auth.repository';
import {AuthenticationGuard} from './service/auth-guard.service';
import {AuthenticationService} from './service/authentication.service';
import {DeviceDetectService} from './service/device-detection.service';
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
        SharedModule,
        RouterModule,
    ],
    declarations: [
        AuthComponent,
        FlashMessageComponent,
        NavBarComponent,
    ],
    exports: [
        FlashMessageComponent,
        NavBarComponent,
    ],
    providers: [
        AuthenticationGuard,
        AuthenticationService,
        AuthRepository,
        DeviceDetectService,
        InViewportService,
        FlashMessageService,
        PageableFactory,
        RoutingService,
        TranslationService,
        {provide: HTTP_INTERCEPTORS, useClass: HeadersInterceptor, multi: true},
        {provide: HTTP_INTERCEPTORS, useClass: FlashMessageInterceptor, multi: true},
        {provide: 'windowObject', useFactory: WindowFactory},
    ],
})
export class CoreModule {
}

export function WindowFactory(): Window {
    return window;
}
