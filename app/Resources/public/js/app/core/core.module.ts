import {CommonModule} from '@angular/common';
import {NgModule} from '@angular/core';
import {FormsModule} from '@angular/forms';
import {RequestOptions} from '@angular/http';
import {RouterModule} from '@angular/router';
import {SharedModule} from '../shared/shared.module';
import {AuthComponent} from './component/auth.component';
import {FlashMessageComponent} from './component/flash-message.component';
import {NavBarComponent} from './component/nav-bar.component';
import {PageableFactory} from './factory/pageable.factory';
import {AuthRepository} from './repository/auth.repository';
import {ApiEventHandler} from './service/api-event.handler';
import {AuthenticationGuard} from './service/auth-guard.service';
import {AuthenticationService} from './service/authentication.service';
import {DefaultRequestOptions} from './service/default-request-options.service';
import {DeviceDetectService} from './service/device-detection.service';
import {FlashMessageService} from './service/flash-message.service';
import {InViewportService} from './service/in-viewport.service';
import {RoutingService} from './service/routing.service';
import {TranslationService} from './service/translation.service';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
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
        ApiEventHandler,
        AuthenticationGuard,
        AuthenticationService,
        AuthRepository,
        DeviceDetectService,
        InViewportService,
        FlashMessageService,
        PageableFactory,
        RoutingService,
        TranslationService,
        {provide: RequestOptions, useClass: DefaultRequestOptions},
        {provide: 'windowObject', useFactory: WindowFactory},
    ],
})
export class CoreModule {
}

export function WindowFactory(): Window {
    return window;
}
